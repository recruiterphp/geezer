<?php

declare(strict_types=1);

namespace Recruiter\Geezer\Leadership;

class Anarchy implements LeadershipStrategy
{
    public function acquire(): bool
    {
        return true;
    }

    public function release(): void
    {
    }

    public function refresh(): bool
    {
        return true;
    }
}
