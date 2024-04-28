<?php

namespace Diff;

function genDiff(string $PathFile1, string $PathFile2)
{
    $array1 = pars($PathFile1);
    $array2 = pars($PathFile2);
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
//var_dump(genDiff('/Users/oleg/IT/php-project-48/tests/fixtures/file1.json', '/Users/oleg/IT/php-project-48/tests/fixtures/file2.json'));