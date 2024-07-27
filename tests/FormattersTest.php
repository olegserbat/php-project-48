<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class FormattersTest extends TestCase
{
    public function testGendiff()
    {
        $path5 = __DIR__ . '/fixtures/file5.json';
        $path6 = __DIR__ . '/fixtures/file6.json';
        $path7 = __DIR__ . '/fixtures/file7.yaml';
        $path8 = __DIR__ . '/fixtures/file8.yaml';
        $expStylish = __DIR__ . '/fixtures/expectStylish.txt';
        $expPlain = __DIR__ . '/fixtures/expectPlain.txt';
        $expJson = __DIR__ . '/fixtures/expectJson.txt';
        $wrongFormat = 'Format is not correct! Please, enter correct format';
        $this->assertStringEqualsFile($expStylish, genDiff($path5, $path6, 'stylish'));
        $this->assertStringEqualsFile($expStylish, genDiff($path7, $path8, 'stylish'));
        $this->assertStringEqualsFile($expStylish, genDiff($path5, $path6));
        $this->assertStringEqualsFile($expStylish, genDiff($path7, $path8));
        $this->assertStringEqualsFile($expPlain, genDiff($path5, $path6, 'plain'));
        $this->assertStringEqualsFile($expPlain, genDiff($path7, $path8, 'plain'));
        $this->assertStringEqualsFile($expJson, genDiff($path5, $path6, 'json'));
        $this->assertEquals($wrongFormat, genDiff($path5, $path6, 'erunda'));
    }
}
