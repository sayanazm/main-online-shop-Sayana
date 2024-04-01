<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3fb4fe753efb6a91fd7a84107dfd405c
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Sayana\\MyLibrary\\' => 17,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Sayana\\MyLibrary\\' => 
        array (
            0 => __DIR__ . '/..' . '/sayana/my-library/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3fb4fe753efb6a91fd7a84107dfd405c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3fb4fe753efb6a91fd7a84107dfd405c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3fb4fe753efb6a91fd7a84107dfd405c::$classMap;

        }, null, ClassLoader::class);
    }
}
