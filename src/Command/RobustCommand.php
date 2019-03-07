<?php

namespace Geezer\Command;

use Geezer\Leadership\LeadershipStrategy;
use Geezer\Timing\WaitStrategy;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;

interface RobustCommand
{
    public function leadershipStrategy(): LeadershipStrategy;

    public function waitStrategy(): WaitStrategy;

    public function name(): string;

    public function description(): string;

    public function definition(): InputDefinition;

    public function init(InputInterface $input): void;

    /**
     * @return bool true on success, false otherwhise (e.g. nothing to do)
     */
    public function execute(): bool;

    /**
     * @return bool true on successful shutdown, false otherwhise
     */
    public function shutdown(): bool;
}
