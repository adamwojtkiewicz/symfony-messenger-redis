<?php

namespace Krak\SymfonyMessengerRedis\Tests\Unit;

use Krak\SymfonyMessengerRedis\Stamp\UniqueStamp;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UniqueStampTest extends TestCase
{
    #[Test]
    public function stamp_creation(): void {
        $stamp = new UniqueStamp('1234');
        $this->assertEquals('1234', $stamp->getId());
    }

    #[Test]
    #[DataProvider('provide_stamps_for_serialization')]
    public function stamp_is_serializable(UniqueStamp $stamp): void {
        $this->assertEquals($stamp, unserialize(serialize($stamp)));
    }

    public static function provide_stamps_for_serialization(): iterable {
        yield 'Stamp without id' => [new UniqueStamp()];
        yield 'Stamp with id' => [new UniqueStamp()];
    }
}
