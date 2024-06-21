<?php

namespace Differ\Differ;

use function Differ\Formatters\formatters;
use function Differ\MakeDiff\makeDiffWithMeta;
use function Differ\Parcers\pars;

function genDiff($pathToFile1, $pathToFile2, $formatName = 'stylish')
{
    $array1 = pars($pathToFile1);
    $array2 = pars($pathToFile2);
    $diff = makeDiffWithMeta($array1, $array2);
    return formatters($diff, $formatName);
}
