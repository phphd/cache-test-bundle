<?php

/** @noinspection PhpDocMissingThrowsInspection */

declare(strict_types=1);

namespace PhPhD\CacheTestBundle\Clearer;

use PhPhD\CacheTestBundle\Accessor\TestContainerAccessor;
use PhPhD\CacheTestBundle\Attribute\ClearPool;
use ReflectionAttribute;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function array_map;
use function is_a;
use function strtok;

/** @internal */
final class TestClearer
{
    private TestContainerAccessor $containerAccessor;

    public function __construct()
    {
        $this->containerAccessor = new TestContainerAccessor();
    }

    public function __invoke(string $testName): void
    {
        /** @var class-string $testClassName */
        $testClassName = strtok($testName, '::');

        if (!$this->supports($testClassName)) {
            return;
        }

        $poolServiceNames = $this->getPoolServiceNames($testClassName);

        if ([] === $poolServiceNames) {
            return;
        }

        $cacheItemPoolsClearer = new CacheItemPoolsClearer($poolServiceNames);

        $this->containerAccessor->runWithContainer($testClassName, $cacheItemPoolsClearer);
    }

    /** @psalm-assert-if-true class-string<KernelTestCase> $testClassName */
    private function supports(string $testClassName): bool
    {
        return is_a($testClassName, KernelTestCase::class, true);
    }

    /**
     * @param class-string<KernelTestCase> $testClassName
     *
     * @return list<string>
     */
    private function getPoolServiceNames(string $testClassName): array
    {
        $clearPools = $this->getClearPoolAttributes($testClassName);

        return array_map(static fn (ClearPool $pool): string => $pool->getName(), $clearPools);
    }

    /**
     * @param class-string<KernelTestCase> $testClassName
     *
     * @return list<ClearPool>
     */
    private function getClearPoolAttributes(string $testClassName): array
    {
        $reflectionClass = new ReflectionClass($testClassName);
        $attributes = $reflectionClass->getAttributes(ClearPool::class);

        return array_map(static fn (ReflectionAttribute $attribute): object => $attribute->newInstance(), $attributes);
    }
}
