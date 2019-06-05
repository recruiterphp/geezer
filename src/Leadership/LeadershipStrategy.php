<?php

namespace Recruiter\Geezer\Leadership;

interface LeadershipStrategy
{
    public function acquire(): bool;

    public function release(): void;

    public function refresh(): bool;
}
