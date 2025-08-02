<?php

declare(strict_types=1);

namespace Recruiter\Geezer\Command;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Recruiter\Geezer\Timing\WaitStrategy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RobustCommandRunner extends Command
{
    private const int CYCLES_BEFORE_GC = 100;

    private const string LEADERSHIP_STATUS_ACQUIRED = 'acquired';
    private const string LEADERSHIP_STATUS_LOST = 'lost';

    private const array STOP_SIGNALS = [
        SIGINT,
        SIGQUIT,
        SIGTERM,
        SIGHUP,
    ];

    private bool $askedToStop = false;

    private int $garbageCollectorCounter = 0;

    private ?string $leadershipStatus;

    public function __construct(private readonly RobustCommand $wrapped, private readonly LoggerInterface $logger)
    {
        parent::__construct($wrapped->name());

        $this->setDescription($wrapped->description());
        $this->setDefinition($wrapped->definition());
        $this->leadershipStatus = null;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->wrapped->init($input);
        $this->registerSignalHandlers();

        $leadershipStrategy = $this->wrapped->leadershipStrategy();
        $waitStrategy = $this->wrapped->waitStrategy();

        $occuredException = null;
        while (!$this->askedToStop()) {
            $this->log('Leadership election');

            $acquired = $leadershipStrategy->acquire();
            if (!$acquired) {
                $this->leadershipWasLost();
                $this->sleepIfNotAskedToStop(1000);
                continue;
            }

            $this->leadershipWasAcquired();

            try {
                $success = $this->wrapped->execute();
            } catch (\Throwable $e) {
                $this->log('Thrown an Exception: ' . get_class($e), ['exception' => $e], LogLevel::ERROR);
                $occuredException = $e;

                break;
            }

            if ($this->wrapped->hasTerminated()) {
                break;
            }

            if ($success) {
                $waitStrategy->rewind();
            }

            $this->sleepAccordingTo($waitStrategy);

            $this->possiblyCollectGarbage();
        }

        $this->wrapped->shutdown($occuredException);

        $leadershipStrategy->release();

        if ($occuredException) {
            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function leadershipWasAcquired(): void
    {
        $this->leadershipStatusChanged(self::LEADERSHIP_STATUS_ACQUIRED, 'leadershipAcquired');
    }

    private function leadershipWasLost(): void
    {
        $this->leadershipStatusChanged(self::LEADERSHIP_STATUS_LOST, 'leadershipLost');
    }

    private function leadershipStatusChanged(?string $newLeadershipStatus, string $hook): void
    {
        if ($this->leadershipStatus === $newLeadershipStatus) {
            return;
        }

        $this->leadershipStatus = $newLeadershipStatus;

        if ($this->wrapped instanceof LeadershipEventsHandler) {
            $this->wrapped->$hook();
        }

        $this->log("Leadership status changed in: `$newLeadershipStatus`");
    }

    private function registerSignalHandlers(): void
    {
        foreach (self::STOP_SIGNALS as $signal) {
            pcntl_signal($signal, function (): void {
                $this->askedToStop = true;
            });
        }
    }

    private function askedToStop(): bool
    {
        if (!$this->askedToStop) {
            pcntl_signal_dispatch();
        }

        return $this->askedToStop;
    }

    private function sleepIfNotAskedToStop(int $milliSeconds): bool
    {
        $microSeconds = $milliSeconds * 1000;
        for ($i = 0; $i < $microSeconds && !$this->askedToStop(); $i += 50000) {
            usleep(50000);
        }

        return $this->askedToStop();
    }

    private function sleepAccordingTo(WaitStrategy $waitStrategy): void
    {
        $this->sleepIfNotAskedToStop($waitStrategy->current());
        $waitStrategy->next();
    }

    private function possiblyCollectGarbage(): void
    {
        if (0 === (++$this->garbageCollectorCounter % self::CYCLES_BEFORE_GC)) {
            gc_collect_cycles();
        }
    }

    /**
     * @param array<mixed> $extra
     */
    private function log(string $message, array $extra = [], string $level = LogLevel::DEBUG): void
    {
        $this->logger->log($level, "[{hostname}:{pid}] $message", array_merge([
            'hostname' => gethostname(),
            'pid' => getmypid(),
            'datetime' => date('c'),
            'program' => $this->wrapped->name(),
        ], $extra));
    }
}
