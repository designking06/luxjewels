<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit85d1ee145d0908cda7c8eb85556ce633
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit85d1ee145d0908cda7c8eb85556ce633::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit85d1ee145d0908cda7c8eb85556ce633::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
