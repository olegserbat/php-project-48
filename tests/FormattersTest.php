<?php

namespace Diff\Tests;

use PHPUnit\Framework\TestCase;

use function Diff\genDiff;

class FormattersTest extends TestCase
{
    public function testGendiff()
    {
        $path1 = __DIR__ . '/fixtures/file1.json';
        $path2 = __DIR__ . '/fixtures/file2.json';
        $expectedLine ="{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}";
        $this->assertEquals($expectedLine, genDiff($path1, $path2));
    }
}
