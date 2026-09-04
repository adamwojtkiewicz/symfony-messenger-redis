<?php

namespace Krak\SymfonyMessengerRedis\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Krak\SymfonyMessengerRedis\Stamp\DebounceStamp;

final class DebounceStampTest extends TestCase
{
    #[Test]
    public function stamp_creation(): void {
        $stamp = new DebounceStamp( 4000, '1234');
        $this->assertEquals(4000, $stamp->getDelay());
        $this->assertEquals('1234', $stamp->getId());
    }

    #[Test]
    #[DataProvider('provide_stamps_for_serialization')]
    public function stamp_is_serializable(DebounceStamp $stamp): void {
        $this->assertEquals($stamp, unserialize(serialize($stamp)));
    }

    public static function provide_stamps_for_serialization(): iterable {
        yield 'Stamp without id' => [new DebounceStamp(3000)];
        yield 'Stamp with id' => [new DebounceStamp(100, '765')];
    }
}
