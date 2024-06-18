<?php

namespace Diff;

use function Diff\pars;
use function Diff\makeDiffWithMeta;
use function Diff\printStylish;
use function Diff\addPath;
use function Diff\printPlain;

function genDiff ($pathToFile1, $pathToFile2, $formatName = 'stylish')
{
    $array1 = \Diff\pars($pathToFile1);
    $array2 = \Diff\pars($pathToFile2);
    $diff = makeDiffWithMeta($array1, $array2);
    switch ($formatName){
        case 'stylish':
           return "{" . \Diff\printStylish($diff) . "\n" . "}";
           break;
        case 'plain':
            return \Diff\printPlain(\Diff\addPath($diff));
            break;
        case 'json':
            return json_encode($diff);
            break;
        default:
            return 'Format is not correct! Please, enter correct format';
    }
}
