<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfccf237c07716bbc42e0fe44977ad9d2
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'OzdemirBurak\\Iris\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'OzdemirBurak\\Iris\\' => 
        array (
            0 => __DIR__ . '/..' . '/ozdemirburak/iris/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfccf237c07716bbc42e0fe44977ad9d2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfccf237c07716bbc42e0fe44977ad9d2::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
