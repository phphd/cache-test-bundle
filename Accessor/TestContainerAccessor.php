<?php

declare(strict_types=1);

namespace PhPhD\CacheTestBundle\Accessor;

use Closure;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/** @internal */
final class TestContainerAccessor
{
    /** @param class-string<KernelTestCase> $testClassName */
    public function runWithContainer(string $testClassName, callable $callback): void
    {
        $container = $this->getContainer($testClassName);

        try {
            $callback($container);
        } finally {
            $this->ensureKernelShutdown($testClassName);
        }
    }

    /** @param class-string<KernelTestCase> $testClassName */
    private function getContainer(string $testClassName): ContainerInterface
    {
        /**
         * @var Closure $getContainer
         *
         * @psalm-suppress NonStaticSelfCall
         * @psalm-suppress TooFewArguments
         *
         * @phpstan-ignore-next-line
         */
        $getContainer = (static fn (): ContainerInterface => self::getContainer())->bindTo(null, $testClassName);

        /** @var ContainerInterface $container */
        $container = $getContainer();

        return $container;
    }

    /** @param class-string<KernelTestCase> $testClassName */
    private function ensureKernelShutdown(string $testClassName): void
    {
        /**
         * @var Closure $shutDown
         *
         * @psalm-suppress NonStaticSelfCall
         * @psalm-suppress TooFewArguments
         *
         * @phpstan-ignore-next-line
         */
        $shutDown = (static fn () => self::ensureKernelShutdown())->bindTo(null, $testClassName);

        $shutDown();
    }
}
