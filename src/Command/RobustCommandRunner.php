<?php

namespace Geezer\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RobustCommandRunner extends Command
{
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

    private const STOP_SIGNALS = [
        SIGINT,
        SIGQUIT,
        SIGTERM,
    ];

    public function __construct(RobustCommand $wrapped, LoggerInterface $logger)
    {
        parent::__construct($wrapped->name());

        $this->wrapped = $wrapped;
        $this->logger = $logger;
        $this->setDescription($wrapped->description());
        $this->setDefinition($wrapped->definition());
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->wrapped->init($input);
        $this->registerSignalHandlers();

        $leadershipStrategy = $this->wrapped->leadershipStrategy();
        $waitStrategy = $this->wrapped->waitStrategy();

        while (!$this->askedToStop()) {
            $this->logger->debug('[{hostname}:{pid}] Leadership election', [
                'pid' => getmypid(),
                'hostname' => gethostname(),
            ]);

            $acquired = $leadershipStrategy->acquire();
            if (!$acquired) {
                $this->sleepIfNotAskedToStop(1);
                $this->logger->debug('[{hostname}:{pid}] Lost the elections', [
                    'pid' => getmypid(),
                    'hostname' => gethostname(),
                ]);
                continue;
            }

            $this->logger->debug('[{hostname}:{pid}] Won the elections', [
                'pid' => getmypid(),
                'hostname' => gethostname(),
            ]);

            $success = $this->wrapped->execute();
            if ($success) {
                $waitStrategy->rewind();
            }

            $this->sleepAccordingTo($waitStrategy);

            $leadershipStrategy->release();
        }

        // probably not needed, ad abundantiam
        $leadershipStrategy->release();
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

    private function sleepIfNotAskedToStop(int $seconds): bool
    {
        for ($i = 0; $i < $seconds && !$this->askedToStop(); ++$i) {
            sleep(1);
        }

        return $this->askedToStop();
    }

    private function sleepAccordingTo(WaitStrategy $waitStrategy): void
    {
        $this->sleepIfNotAskedToStop($waitStrategy->current());
        $waitStrategy->next();
    }
}