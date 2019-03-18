<?php

namespace Geezer\Timing;

class ConstantPause implements WaitStrategy
{
    /**
     * @var int
     */
    private $attempt = 0;

    /**
     * @var int
     */
    private $pause;

    /**
     * ConstantPause constructor.
     *
     * @param int $pause milliseconds to wait
     */
    public function __construct(int $pause)
    {
        $this->pause = $pause;
    }

    /**
     * Number of milliseconds to wait.
     *
     * @return int
     */
    public function current(): int
    {
        return $this->pause;
    }

    /**
     * Return the key of the current element.
     *
     * @see https://php.net/manual/en/iterator.key.php
     *
     * @return int
     *
     * @since 5.0.0
     */
    public function key(): int
    {
        return $this->attempt;
    }

    /**
     * Checks if current position is valid.
     *
     * @see https://php.net/manual/en/iterator.valid.php
     *
     * @return bool the return value will be casted to boolean and then evaluated.
     *              Returns true on success or false on failure
     *
     * @since 5.0.0
     */
    public function valid(): bool
    {
        return true;
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @see https://php.net/manual/en/iterator.rewind.php
     * @since 5.0.0
     */
    public function rewind(): void
    {
        $this->attempt = 0;
    }

    /**
     * Move forward to next element.
     *
     * @see https://php.net/manual/en/iterator.next.php
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->attempt;
    }
}
