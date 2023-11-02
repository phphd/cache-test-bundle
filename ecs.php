<?php

declare(strict_types=1);

use PhPhD\CodingStandard\ValueObject\Set\PhdSetList;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([__DIR__.'/']);
    $ecsConfig->skip([__DIR__.'/vendor']);

    $ecsConfig->sets([PhdSetList::ecs()->getPath()]);
};
