<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\pars;


class ParcersTest extends TestCase
{
    public function testPars()
    {
        $path1 = __DIR__ . '/fixtures/file1.json';
        $path2 = __DIR__ . '/fixtures/file3.yaml';
        $path3 = __DIR__ . '/fixtures/file123.json';
        $path4 = __DIR__ . '/fixtures/file1.txt';
        $rightArray = [
            'host' => "hexlet.io",
            'timeout' => 50,
            'proxy' => "123.234.53.22",
            'follow' => false];
        $this->assertEquals($rightArray, pars($path1));
        $this->assertEquals($rightArray, pars($path2));
        $this->assertEquals([], pars($path3));
        $this->assertEquals([], pars($path4));
    }
}
