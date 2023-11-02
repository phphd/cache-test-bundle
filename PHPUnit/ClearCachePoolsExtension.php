<?php

declare(strict_types=1);

namespace PhPhD\CacheTestBundle\PHPUnit;

use PhPhD\CacheTestBundle\Clearer\TestClearer;
use PHPUnit\Runner\BeforeTestHook;

final class ClearCachePoolsExtension implements BeforeTestHook
{
    private TestClearer $testClearer;

    public function __construct()
    {
        $this->testClearer = new TestClearer();
    }

    public function executeBeforeTest(string $test): void
    {
        $this->testClearer->__invoke($test);
    }
}
