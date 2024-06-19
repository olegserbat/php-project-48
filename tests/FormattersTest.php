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
        $path3 = __DIR__ . '/fixtures/file3.yaml';
        $path4 = __DIR__ . '/fixtures/file4.yaml';
        $path5 = __DIR__ . '/fixtures/file5.json';
        $path6 = __DIR__ . '/fixtures/file6.json';
        $path7 = __DIR__ . '/fixtures/file7.yaml';
        $path8 = __DIR__ . '/fixtures/file8.yaml';
        $expectedLineStylish1 = "{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}";

        $expectedLineStylish2 = "{
    common: {
      + follow: false
        setting1: Value 1
      - setting2: 200
      - setting3: true
      + setting3: null
      + setting4: blah blah
      + setting5: {
            key5: value5
        }
        setting6: {
            doge: {
              - wow: 
              + wow: so much
            }
            key: value
          + ops: vops
        }
    }
    group1: {
      - baz: bas
      + baz: bars
        foo: bar
      - nest: {
            key: value
        }
      + nest: str
    }
  - group2: {
        abc: 12345
        deep: {
            id: 45
        }
    }
  + group3: {
        deep: {
            id: {
                number: 45
            }
        }
        fee: 100500
    }
}";
        $expectedLinePlain1 = "
Property 'follow' was removed
Property 'proxy' was removed
Property 'timeout' was updated. From '50' to '20'
Property 'verbose' was added with value: 'true'";
        $expectedLinePlain2 = "
Property 'common.follow' was added with value: 'false'
Property 'common.setting2' was removed
Property 'common.setting3' was updated. From 'true' to 'null'
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: [complex value]
Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
Property 'common.setting6.ops' was added with value: 'vops'
Property 'group1.baz' was updated. From 'bas' to 'bars'
Property 'group1.nest' was updated. From [complex value] to 'str'
Property 'group2' was removed
Property 'group3' was added with value: [complex value]";
        $this->assertEquals($expectedLineStylish1, genDiff($path1, $path2));
        $this->assertEquals($expectedLineStylish1, genDiff($path3, $path4));
        $this->assertEquals($expectedLineStylish2, genDiff($path5, $path6));
        $this->assertEquals($expectedLineStylish2, genDiff($path7, $path8));
        $this->assertEquals($expectedLinePlain1, genDiff($path1, $path2, 'plain'));
        $this->assertEquals($expectedLinePlain1, genDiff($path3, $path4, 'plain'));
        $this->assertEquals($expectedLinePlain2, genDiff($path5, $path6, 'plain'));
        $this->assertEquals($expectedLinePlain2, genDiff($path7, $path8, 'plain'));
    }
}
