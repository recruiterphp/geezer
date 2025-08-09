<?php

declare(strict_types=1);

namespace Recruiter\Geezer\Leadership;

use Recruiter\Concurrency\Lock;
use Recruiter\Concurrency\LockNotAvailableException;

final readonly class Dictatorship implements LeadershipStrategy
{
    /**
     * Dictatorship constructor.
     */
    public function __construct(private Lock $lock, private int $termOfOffice)
    {
    }

    public function acquire(): bool
    {
        if ($this->refresh()) {
            return true;
        }

        try {
            $this->lock->wait(1, (int) ($this->termOfOffice * .3));
            $this->lock->acquire($this->termOfOffice);
        } catch (LockNotAvailableException) {
            return false;
        }

        return true;
    }

    public function release(): void
    {
        try {
            $this->lock->release();
        } catch (LockNotAvailableException) {
        }
    }

    public function refresh(): bool
    {
        try {
            $this->lock->refresh($this->termOfOffice);
        } catch (LockNotAvailableException) {
            return false;
        }

        return true;
    }
}
