<?php

namespace Differ;

use Symfony\Component\Yaml\Yaml;

//require_once "../vendor/autoload.php";

function pars(string $path): array
{
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    if (file_exists($path) and $extension === 'json') {
        $dataFile = file_get_contents($path);
        $array = json_decode($dataFile, true);
        return $array;
    } elseif (file_exists($path) and ($extension === 'yaml' or $extension === 'yml')) {
        $array = Yaml::parseFile($path);
        return $array;
    }
    return [];
}
