<?php

namespace Geezer\Command;

use Iterator;

interface WaitStrategy extends Iterator
{
    /**
     * Number of milliseconds to wait.
     *
     * @return int
     */
    public function current(): int;
}
