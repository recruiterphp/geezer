<?php

namespace Test\Geezer\Timing;

use Geezer\Timing\ExponentialBackoffStrategy;
use PHPUnit\Framework\TestCase;

class ExponentialBackoffStrategyTest extends TestCase
{
    public function testNextWorksCorrectly()
    {
        $strategy = new ExponentialBackoffStrategy(100, 1000);
        $this->assertEquals(0, $strategy->current());
        $strategy->next();
        $this->assertEquals(100, $strategy->current());
        $strategy->next();
        $this->assertEquals(200, $strategy->current());
        $strategy->next();
        $this->assertEquals(400, $strategy->current());
        $strategy->next();
        $this->assertEquals(800, $strategy->current());
        $strategy->next();
        $this->assertEquals(1000, $strategy->current());
        $strategy->next();
        $this->assertEquals(1000, $strategy->current());

        $strategy->rewind();
        $this->assertEquals(0, $strategy->current());
        $strategy->next();
        $this->assertEquals(100, $strategy->current());
    }
}
