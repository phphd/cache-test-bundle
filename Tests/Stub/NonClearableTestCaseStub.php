<?php

declare(strict_types=1);

namespace PhPhD\CacheTestBundle\Tests\Stub;

use PhPhD\CacheTestBundle\Attribute\ClearPool;
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
