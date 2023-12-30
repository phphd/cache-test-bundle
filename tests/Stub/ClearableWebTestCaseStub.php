<?php

declare(strict_types=1);

namespace PhPhD\CacheTest\Tests\Stub;

use PhPhD\CacheTest\ClearPool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
#[ClearPool('web')]
final class ClearableWebTestCaseStub extends WebTestCase
{
    public function testTrue(): void
    {
        self::assertTrue(true);
    }
}
