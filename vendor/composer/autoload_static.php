<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteee115c7b66c9a1fa856116399beb7c1
{
    public static $files = array (
        'e88992873b7765f9b5710cab95ba5dd7' => __DIR__ . '/..' . '/hoa/consistency/Prelude.php',
        '3e76f7f02b41af8cea96018933f6b7e3' => __DIR__ . '/..' . '/hoa/protocol/Wrapper.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Cache\\' => 10,
            'PHPStan\\PhpDocParser\\' => 21,
        ),
        'M' => 
        array (
            'Metadata\\' => 9,
        ),
        'J' => 
        array (
            'JMS\\Serializer\\' => 15,
        ),
        'H' => 
        array (
            'Hoa\\Zformat\\' => 12,
            'Hoa\\Visitor\\' => 12,
            'Hoa\\Ustring\\' => 12,
            'Hoa\\Stream\\' => 11,
            'Hoa\\Regex\\' => 10,
            'Hoa\\Protocol\\' => 13,
            'Hoa\\Math\\' => 9,
            'Hoa\\Iterator\\' => 13,
            'Hoa\\File\\' => 9,
            'Hoa\\Exception\\' => 14,
            'Hoa\\Event\\' => 10,
            'Hoa\\Consistency\\' => 16,
            'Hoa\\Compiler\\' => 13,
        ),
        'F' => 
        array (
            'Faker\\' => 6,
        ),
        'D' => 
        array (
            'Doctrine\\Instantiator\\' => 22,
            'Doctrine\\Deprecations\\' => 22,
            'Doctrine\\Common\\Lexer\\' => 22,
            'Doctrine\\Common\\Annotations\\' => 28,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/cache/src',
        ),
        'PHPStan\\PhpDocParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpstan/phpdoc-parser/src',
        ),
        'Metadata\\' => 
        array (
            0 => __DIR__ . '/..' . '/jms/metadata/src',
        ),
        'JMS\\Serializer\\' => 
        array (
            0 => __DIR__ . '/..' . '/jms/serializer/src',
        ),
        'Hoa\\Zformat\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/zformat',
        ),
        'Hoa\\Visitor\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/visitor',
        ),
        'Hoa\\Ustring\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/ustring',
        ),
        'Hoa\\Stream\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/stream',
        ),
        'Hoa\\Regex\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/regex',
        ),
        'Hoa\\Protocol\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/protocol',
        ),
        'Hoa\\Math\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/math',
        ),
        'Hoa\\Iterator\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/iterator',
        ),
        'Hoa\\File\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/file',
        ),
        'Hoa\\Exception\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/exception',
        ),
        'Hoa\\Event\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/event',
        ),
        'Hoa\\Consistency\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/consistency',
        ),
        'Hoa\\Compiler\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoa/compiler',
        ),
        'Faker\\' => 
        array (
            0 => __DIR__ . '/..' . '/fzaninotto/faker/src/Faker',
        ),
        'Doctrine\\Instantiator\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/instantiator/src/Doctrine/Instantiator',
        ),
        'Doctrine\\Deprecations\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/deprecations/lib/Doctrine/Deprecations',
        ),
        'Doctrine\\Common\\Lexer\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/lexer/src',
        ),
        'Doctrine\\Common\\Annotations\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/annotations/lib/Doctrine/Common/Annotations',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteee115c7b66c9a1fa856116399beb7c1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteee115c7b66c9a1fa856116399beb7c1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticIniteee115c7b66c9a1fa856116399beb7c1::$classMap;

        }, null, ClassLoader::class);
    }
}
