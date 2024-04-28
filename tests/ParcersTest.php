<?php

namespace Diff\Tests;

use PHPUnit\Framework\TestCase;
use function Diff\pars;


class ParcersTest extends TestCase
{
    public function testPars()
    {
        $path1 = '/Users/oleg/IT/php-project-48/tests/fixtures/file1.json';
        $path2 = '/Users/oleg/IT/php-project-48/tests/fixtures/file3.yaml';
        $path3 = '/Users/oleg/IT/php-project-48/tests/fixtures/file333.yaml';
        $path4 = '/Users/oleg/IT/php-project-48/tests/fixtures/file3.txt';
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
