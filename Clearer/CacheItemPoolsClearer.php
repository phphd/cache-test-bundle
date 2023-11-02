<?php

declare(strict_types=1);

namespace PhPhD\CacheTestBundle\Clearer;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UnexpectedValueException;

use function array_map;
use function sprintf;

/** @internal */
final class CacheItemPoolsClearer
{
    public function __construct(
        /** @var list<string> */
        private array $poolsServiceNames,
    ) {
    }

    public function __invoke(ContainerInterface $container): void
    {
        $pools = $this->getPools($container);

        $this->clearPools($pools);
    }

    /** @return list<CacheItemPoolInterface> */
    private function getPools(ContainerInterface $container): array
    {
        return array_map(static function (string $poolServiceName) use ($container) {
            /** @var CacheItemPoolInterface $pool */
            $pool = $container->get($poolServiceName);

            if (!$pool instanceof CacheItemPoolInterface) {
                throw new UnexpectedValueException(
                    sprintf('Expected the service "%s" to be instance of %s', $poolServiceName, CacheItemPoolInterface::class),
                );
            }

            return $pool;
        }, $this->poolsServiceNames);
    }

    /** @param list<CacheItemPoolInterface> $pools */
    private function clearPools(array $pools): void
    {
        array_map(
            static fn (CacheItemPoolInterface $pool): bool => $pool->clear(),
            $pools,
        );
    }
}
