<?php

namespace Differ\Differ;

use function Differ\Formatters\ChooseFormatDiffer;
use function Differ\Parcers\makeParsing;
use function Functional\sort;

function makeDiffWithMeta(array $arr1, array $arr2)
{
    $keys = array_unique(array_merge(array_keys($arr1), array_keys($arr2)));
    $sortKeys = sort($keys, fn($left, $right) => strcmp($left, $right));
    return array_map(function ($key) use ($arr1, $arr2) {
        if (array_key_exists($key, $arr1) and !array_key_exists($key, $arr2)) {
            return ['key' => $key, 'status' => '-', 'arg' => $arr1[$key]];
        } elseif (!array_key_exists($key, $arr1) and array_key_exists($key, $arr2)) {
            return ['key' => $key, 'status' => '+', 'arg' => $arr2[$key]];
        } elseif (array_key_exists($key, $arr1) and array_key_exists($key, $arr2)) {
            if (is_array($arr1[$key]) and is_array($arr2[$key])) {
                return ['key' => $key, 'status' => 'no', 'arg' => makeDiffWithMeta($arr1[$key], $arr2[$key])];
            } elseif ($arr1[$key] === $arr2[$key]) {
                return ['key' => $key, 'status' => 'both', 'arg' => $arr1[$key]];
            } else {
                return ['key' => $key, 'status' => 'complex', 'arg' => ['old' => $arr1[$key], 'new' => $arr2[$key]]];
            }
        }
    }, $sortKeys);
}

function genDiff(string $pathToFile1, string $pathToFile2, string $formatName = 'stylish')
{
    $dataFromFile1 = makeParsing($pathToFile1);
    $dataFromFile2 = makeParsing($pathToFile2);
    $diff = makeDiffWithMeta($dataFromFile1, $dataFromFile2);
    return ChooseFormatDiffer($diff, $formatName);
}
