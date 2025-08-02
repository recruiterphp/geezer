<?php

declare(strict_types=1);

namespace Test\Geezer\Timing;

use PHPUnit\Framework\TestCase;
use Recruiter\Geezer\Timing\ExponentialBackoffStrategy;

class ExponentialBackoffStrategyTest extends TestCase
{
    public function testNextWorksCorrectly(): void
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
