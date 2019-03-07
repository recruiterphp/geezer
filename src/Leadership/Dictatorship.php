<?php

namespace Geezer\Leadership;

use Onebip\Concurrency\Lock;
use Onebip\Concurrency\LockNotAvailableException;

class Dictatorship implements LeadershipStrategy
{
    /**
     * @var Lock
     */
    private $lock;

    /**
     * @var int seconds
     */
    private $termOfOffice;

    /**
     * Dictatorship constructor.
     *
     * @param Lock $lock
     * @param int  $termOfOffice
     */
    public function __construct(Lock $lock, int $termOfOffice)
    {
        $this->lock = $lock;
        $this->termOfOffice = $termOfOffice;
    }

    public function acquire(): bool
    {
        if ($this->refresh()) {
            return true;
        }

        try {
            $this->lock->wait(1, (int) ($this->termOfOffice * .3));
            $this->lock->acquire($this->termOfOffice);
        } catch (LockNotAvailableException $e) {
            return false;
        }

        return true;
    }

    public function release(): void
    {
        try {
            $this->lock->release();
        } catch (LockNotAvailableException $e) {
        }
    }

    public function refresh(): bool
    {
        try {
            $this->lock->refresh($this->termOfOffice);
        } catch (LockNotAvailableException $e) {
            return false;
        }

        return true;
    }
}
