<?php

namespace Differ\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function makePath(string $fileName): string
    {
        return __DIR__ . "$fileName";
    }

    public static function dataForTest()
    {
        return [['json'], ['yaml']];
    }

    #[DataProvider('dataForTest')]
    public function testGendiffStylish($file, $format = 'stylish')
    {
        $path1 = __DIR__ . '/fixtures/file5.' . $file;
        $path2 = __DIR__ . '/fixtures/file6.' . $file;
        $exp = __DIR__ . '/fixtures/expectStylish.txt';
        $this->assertStringEqualsFile($exp, genDiff($path1, $path2, $format));
    }

    #[DataProvider('dataForTest')]
    public function testGendiffWithoutFormat($file)
    {
        $path1 = __DIR__ . '/fixtures/file5.' . $file;
        $path2 = __DIR__ . '/fixtures/file6.' . $file;
        $exp = __DIR__ . '/fixtures/expectStylish.txt';
        $this->assertStringEqualsFile($exp, genDiff($path1, $path2));
    }

    #[DataProvider('dataForTest')]
    public function testGendiffPlain($file, $format = 'plain')
    {
        $path1 = __DIR__ . '/fixtures/file5.' . $file;
        $path2 = __DIR__ . '/fixtures/file6.' . $file;
        $exp = __DIR__ . '/fixtures/expectPlain.txt';
        $this->assertStringEqualsFile($exp, genDiff($path1, $path2, $format));
    }

    #[DataProvider('dataForTest')]
    public function testGendiffWrongFormat($file, $format = 'erunda')
    {
        $path1 = __DIR__ . '/fixtures/file5.' . $file;
        $path2 = __DIR__ . '/fixtures/file6.' . $file;
        $exp = 'Format is not correct! Please, enter correct format';
        $this->assertEquals($exp, genDiff($path1, $path2, $format));
    }
}
