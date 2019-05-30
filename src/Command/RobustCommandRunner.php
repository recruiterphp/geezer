<?php

namespace Geezer\Command;

use Exception;
use Geezer\Timing\WaitStrategy;
use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RobustCommandRunner extends Command
{
    private const CYCLES_BEFORE_GC = 100;

    private const LEADERSHIP_STATUS_ACQUIRED = 'acquired';
    private const LEADERSHIP_STATUS_LOST = 'lost';

    private const STOP_SIGNALS = [
        SIGINT,
        SIGQUIT,
        SIGTERM,
        SIGHUP,
    ];

    /**
     * @var RobustCommand
     */
    private $wrapped;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var bool
     */
    private $askedToStop = false;

    private $garbageCollectorCounter = 0;

    private $leadershipStatus = null;

    public function __construct(RobustCommand $wrapped, LoggerInterface $logger)
    {
        parent::__construct($wrapped->name());

        $this->wrapped = $wrapped;
        $this->logger = $logger;
        $this->setDescription($wrapped->description());
        $this->setDefinition($wrapped->definition());
        $this->leadershipStatus = null;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
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
                $this->whenLeadershipsStatusChange(self::LEADERSHIP_STATUS_LOST, function () {
                    $this->wrapped->leadershipLost();
                    $this->log('Lost the elections');
                });
                $this->sleepIfNotAskedToStop(1000);
                continue;
            }

            $this->whenLeadershipsStatusChange(self::LEADERSHIP_STATUS_ACQUIRED, function () {
                $this->wrapped->leadershipAcquired();
                $this->log('Won the elections');
            });

            try {
                $success = $this->wrapped->execute();
            } catch (Exception $e) {
                $this->log('Thrown an Exception: ' . get_class($e), ['exception' => $e], LogLevel::ERROR);
                $occuredException = $e;

                break;
            }
            if ($success) {
                $waitStrategy->rewind();
            }

            $this->sleepAccordingTo($waitStrategy);

            $this->possiblyCollectGarbage();
        }

        $this->wrapped->shutdown($occuredException);

        // probably not needed, ad abundantiam
        $leadershipStrategy->release();
    }

    private function whenLeadershipsStatusChange($newLeadershipStatus, callable $do)
    {
        if ($this->leadershipStatus !== $newLeadershipStatus) {
            $this->leadershipStatus = $newLeadershipStatus;
            $do();
        }
    }

    private function registerSignalHandlers(): void
    {
        foreach (self::STOP_SIGNALS as $signal) {
            pcntl_signal($signal, function () {
                $this->askedToStop = true;
            });
        }
    }

    private function askedToStop()
    {
        if (!$this->askedToStop) {
            pcntl_signal_dispatch();
        }

        return $this->askedToStop;
    }

    private function sleepIfNotAskedToStop(int $milliSeconds): bool
    {
        $microSeconds = $milliSeconds * 1000;
        for ($i = 0; $i < $microSeconds && !$this->askedToStop(); $i = $i + 50000) {
            usleep(50000);
        }

        return $this->askedToStop();
    }

    private function sleepAccordingTo(WaitStrategy $waitStrategy): void
    {
        $this->sleepIfNotAskedToStop($waitStrategy->current());
        $waitStrategy->next();
    }

    private function possiblyCollectGarbage(): int
    {
        if (0 === (++$this->garbageCollectorCounter % self::CYCLES_BEFORE_GC)) {
            return gc_collect_cycles();
        }

        return 0;
    }

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
