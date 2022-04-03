<?php

namespace WJCrypto\DI;

use DI\ContainerBuilder;
use Jenssegers\Blade\Blade;
use WJCrypto\Controllers\FrontendController;
use WJCrypto\Controllers\UserController;
use WJCrypto\Models\DbModel;
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
            'Database' => factory(function () {
                return new DbModel();
            }),

            'Blade' => factory(function () {
                return new Blade(__DIR__ . '/../Views', __DIR__ . '/../Views/cache');
            }),

            'UserController' => factory(function () {
                return new UserController();
            }),

            'FrontendController' => factory(function () {
                return new FrontendController();
            })
        ]);

        return self::$builder->build();
    }
}
