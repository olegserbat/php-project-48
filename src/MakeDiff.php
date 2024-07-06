<?php

namespace Differ\MakeDiff;

use function Functional\reduce_left;

function makeDiffWithMeta(array $arr1, array $arr2)
{
    $keys = array_unique(array_merge(array_keys($arr1), array_keys($arr2)));
    sort($keys);
    $arrayWithMeta = reduce_left($keys, function ($key, $index, $keys, $result) use ($arr1, $arr2) {
        if (array_key_exists($key, $arr1) and !array_key_exists($key, $arr2)) {
            $result[$key] = ['status' => '-', 'arg' => $arr1[$key]];
        } elseif (!array_key_exists($key, $arr1) and array_key_exists($key, $arr2)) {
            $result[$key] = ['status' => '+', 'arg' => $arr2[$key]];
        } elseif (array_key_exists($key, $arr1) and array_key_exists($key, $arr2)) {
            if (is_array($arr1[$key]) and is_array($arr2[$key])) {
                $result[$key] = ['status' => 'no', 'arg' => makeDiffWithMeta($arr1[$key], $arr2[$key])];
            } elseif ($arr1[$key] === $arr2[$key]) {
                $result[$key] = ['status' => 'both', 'arg' => $arr1[$key]];
            } else {
                $result[$key] = ['status' => 'complex', 'arg' => ['old' => $arr1[$key], 'new' => $arr2[$key]]];
            }
        }
        return $result;
    }, []);
    return $arrayWithMeta;
}

function printSomeWord(mixed $str)
{
    if ($str === false) {
        return 'false';
    } elseif ($str === true) {
        return 'true';
    } elseif ($str === null) {
        return 'null';
    } else {
        return $str;
    }
}
