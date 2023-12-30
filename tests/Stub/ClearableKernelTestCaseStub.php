<?php

declare(strict_types=1);

namespace PhPhD\CacheTest\Tests\Stub;

use PhPhD\CacheTest\ClearPool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
#[ClearPool('first')]
#[ClearPool('second')]
final class ClearableKernelTestCaseStub extends KernelTestCase
{
    public function testTrue(): void
    {
        self::assertTrue(true);
    }
}
