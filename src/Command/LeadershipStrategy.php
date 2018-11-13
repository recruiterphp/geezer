<?php

namespace Geezer\Command;

interface LeadershipStrategy
{
    public function acquire(): bool;

    public function release(): void;

    public function refresh(): bool;
}
