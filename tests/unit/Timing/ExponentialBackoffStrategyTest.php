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
        $this->assertSame(0, $strategy->current());
        $strategy->next();
        $this->assertSame(100, $strategy->current());
        $strategy->next();
        $this->assertSame(200, $strategy->current());
        $strategy->next();
        $this->assertSame(400, $strategy->current());
        $strategy->next();
        $this->assertSame(800, $strategy->current());
        $strategy->next();
        $this->assertSame(1000, $strategy->current());
        $strategy->next();
        $this->assertSame(1000, $strategy->current());

        $strategy->rewind();
        $this->assertSame(0, $strategy->current());
        $strategy->next();
        $this->assertSame(100, $strategy->current());
    }
}
