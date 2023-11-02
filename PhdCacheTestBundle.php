<?php

declare(strict_types=1);

namespace PhPhD\CacheTestBundle;

use PhPhD\CacheTestBundle\DependencyInjection\PhdCacheTestExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class PhdCacheTestBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return $this->extension ??= new PhdCacheTestExtension();
    }
}
