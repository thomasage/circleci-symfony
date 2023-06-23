<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $parameters = $rectorConfig->parameters();
    $parameters->set(Option::PARALLEL, true);
    $parameters->set(Option::PARALLEL_MAX_NUMBER_OF_PROCESSES, 4);

    $rectorConfig->paths([
        __DIR__.'/config',
        __DIR__.'/public',
        __DIR__.'/src',
        __DIR__.'/tests',
    ]);

    $rectorConfig->skip([
        __DIR__.'/public/build',
        __DIR__.'/public/bundles',
        ClassPropertyAssignToConstructorPromotionRector::class => [
            __DIR__.'/src/Entity',
        ],
    ]);

    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    $rectorConfig->sets([
        DoctrineSetList::DOCTRINE_CODE_QUALITY,
        LevelSetList::UP_TO_PHP_82,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::PRIVATIZATION,
        SetList::TYPE_DECLARATION,
    ]);
    $rectorConfig->phpVersion(PhpVersion::PHP_81);
};
