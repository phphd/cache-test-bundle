<?php

declare(strict_types=1);

namespace PhPhD\CacheTest\Tests\Stub;

use PhPhD\CacheTest\ClearPool;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
#[ClearPool('wont_clear')]
final class NonClearableTestCaseStub extends TestCase
{
    public function testTrue(): void
    {
        self::assertTrue(true);
    }
}
