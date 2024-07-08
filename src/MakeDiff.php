<?php

namespace Differ\MakeDiff;

use function Functional\reduce_left;

function makeDiffWithMeta(array $arr1, array $arr2)
{
    $keys = array_unique(array_merge(array_keys($arr1), array_keys($arr2)));
    sort($keys);
    return array_reduce($keys, function ($result, $key) use ($arr1, $arr2) {
        $value = [];
        if (array_key_exists($key, $arr1) and !array_key_exists($key, $arr2)) {
            $value = ['status' => '-', 'arg' => $arr1[$key]];
        } elseif (!array_key_exists($key, $arr1) and array_key_exists($key, $arr2)) {
            $value = ['status' => '+', 'arg' => $arr2[$key]];
        } elseif (array_key_exists($key, $arr1) and array_key_exists($key, $arr2)) {
            if (is_array($arr1[$key]) and is_array($arr2[$key])) {
                $value = ['status' => 'no', 'arg' => makeDiffWithMeta($arr1[$key], $arr2[$key])];
            } elseif ($arr1[$key] === $arr2[$key]) {
                $value = ['status' => 'both', 'arg' => $arr1[$key]];
            } else {
                $value = ['status' => 'complex', 'arg' => ['old' => $arr1[$key], 'new' => $arr2[$key]]];
            }
        } $result[$key] = $value;
        return $result;
    }, []);
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
