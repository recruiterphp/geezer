<?php

declare(strict_types=1);

namespace Recruiter\Geezer\Leadership;

interface LeadershipStrategy
{
    public function acquire(): bool;

    public function release(): void;

    public function refresh(): bool;
}
