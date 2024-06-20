<?php

namespace Differ;

function genDiff($pathToFile1, $pathToFile2, $formatName = 'stylish')
{
    $array1 = \Differ\pars($pathToFile1);
    $array2 = \Differ\pars($pathToFile2);
    $diff = makeDiffWithMeta($array1, $array2);
    switch ($formatName) {
        case 'stylish':
            return "{" . \Differ\printStylish($diff) . "\n" . "}";
            break;
        case 'plain':
            return \Differ\printPlain(\Differ\addPath($diff));
            break;
        case 'json':
            return json_encode($diff);
            break;
        default:
            return 'Format is not correct! Please, enter correct format';
    }
}
