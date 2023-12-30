<?php

declare(strict_types=1);

use PhPhD\CodingStandard\ValueObject\Set\PhdSetList;
use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([__DIR__.'/']);
    $rectorConfig->skip([__DIR__.'/vendor']);

    $rectorConfig->sets([PhdSetList::rector()->getPath()]);
    $rectorConfig->phpVersion(PhpVersion::PHP_80);

    $rectorConfig->skip([
        CallableThisArrayToAnonymousFunctionRector::class => [
            __DIR__.'/tests',
        ],
    ]);
};
