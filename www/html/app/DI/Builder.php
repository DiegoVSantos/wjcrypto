<?php

namespace WJCrypto\DI;

use DI\ContainerBuilder;
use Jenssegers\Blade\Blade;
use function DI\factory;

class Builder
{
    private static $builder;

    /**
     * @throws \Exception
     */
    public static function buildContainer()
    {
        self::$builder = new ContainerBuilder();

        self::$builder->addDefinitions([
            'Blade' => factory(function () {
                return new Blade(__DIR__ . '/../Views', __DIR__ . '/../Views/cache');
            })
        ]);

        return self::$builder->build();
    }
}
