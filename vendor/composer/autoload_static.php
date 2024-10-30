<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2beb22e5fa754a85205d57de243c3435
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'IgniterAuth\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'IgniterAuth\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2beb22e5fa754a85205d57de243c3435::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2beb22e5fa754a85205d57de243c3435::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2beb22e5fa754a85205d57de243c3435::$classMap;

        }, null, ClassLoader::class);
    }
}
