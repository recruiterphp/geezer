<?php

namespace Geezer\Timing;

class ExponentialBackoffStrategy implements WaitStrategy
{
    /**
     * @var int
     */
    private $attempt = 0;

    /**
     * @var int
     */
    private $from;

    /**
     * @var int
     */
    private $to;

    /**
     * ExponentialBackoffStrategy constructor.
     *
     * @param int $from minimum milliseconds to wait (on second attempt)
     * @param int $to   maximum milliseconds to wait
     */
    public function __construct(int $from, int $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * Number of milliseconds to wait.
     *
     * @return int
     */
    public function current(): int
    {
        if (0 === $this->attempt) {
            return 0;
        }

        return intval(min(
            2 ** ($this->attempt - 1) * $this->from,
            $this->to
        ));
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
