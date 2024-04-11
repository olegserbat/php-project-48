<?php

namespace Diff;

function genDiff(string $PathFile1, string $PathFile2)
{
    $dataFile1 = file_get_contents($PathFile1);
    $array1 = json_decode($dataFile1, true);
    $dataFile2 = file_get_contents($PathFile2);
    $array2 = json_decode($dataFile2, true);
    ksort($array1);
    ksort($array2);
    $result = [];
    foreach ($array1 as $key => $value) {
        if ($value === true) {
            $value = 'true';
        } elseif ($value === false) {
            $value = 'false';
        }
        if (array_key_exists($key, $array2) and $value === $array2[$key]) {
            $result[] = "   {$key}: {$value}";
        } else {
            $result[] = " - {$key}: {$value}";
        }
    }
    foreach ($array2 as $key => $value) {
        if ($value === true) {
            $value = 'true';
        } elseif ($value === false) {
            $value = 'false';
        }
        if (!array_key_exists($key, $array1) or $value !== $array1[$key]) {
            $result[] = " + {$key}: {$value}";
        }
    }

    return "\n" . "{" . "\n" . implode("\n", $result) . "\n" . "}";
}
