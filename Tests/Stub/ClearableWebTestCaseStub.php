<?php

declare(strict_types=1);

namespace PhPhD\CacheTestBundle\Tests\Stub;

use PhPhD\CacheTestBundle\Attribute\ClearPool;
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
