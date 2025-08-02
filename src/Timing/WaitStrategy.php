<?php

declare(strict_types=1);

namespace Recruiter\Geezer\Timing;

/**
 * @extends \Iterator<int, int>
 */
interface WaitStrategy extends \Iterator
{
    /**
     * Number of milliseconds to wait.
     */
    public function current(): int;
}
