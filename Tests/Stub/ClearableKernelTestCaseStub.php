<?php

declare(strict_types=1);

namespace PhPhD\CacheTestBundle\Tests\Stub;

use PhPhD\CacheTestBundle\Attribute\ClearPool;
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
