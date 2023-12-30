<?php

declare(strict_types=1);

namespace PhPhD\CacheTest\Tests\Stub\Outlet;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class KernelTestCaseStub extends TestCase
{
    private static ?ContainerInterface $container = null;

    private static bool $isKernelBooted = false;

    public static function setContainer(?ContainerInterface $container): void
    {
        self::$container = $container;
    }

    public static function isKernelBooted(): bool
    {
        return self::$isKernelBooted;
    }

    /** @psalm-suppress PossiblyUnusedMethod */
    protected static function getContainer(): ?ContainerInterface
    {
        self::$isKernelBooted = true;

        return self::$container;
    }

    /** @psalm-suppress PossiblyUnusedMethod */
    protected static function ensureKernelShutdown(): void
    {
        self::$isKernelBooted = false;
    }
}
