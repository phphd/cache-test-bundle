<?php

declare(strict_types=1);

namespace PhPhD\CacheTestBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

final class PhdCacheTestExtension extends Extension
{
    public const ALIAS = 'phd_cache_test';

    /**
     * @param array<array-key,mixed> $configs
     *
     * @override
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        // nothing to do yet
    }

    /** @override */
    public function getAlias(): string
    {
        return self::ALIAS;
    }
}
