<?php

namespace Differ\Parcers;

use Symfony\Component\Yaml\Yaml;

function pars(string $path): array
{
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    if (file_exists($path) and $extension === 'json') {
        $dataFile = file_get_contents($path);
        $array = json_decode((string)$dataFile, true);
        return $array;
    } elseif (file_exists($path) and ($extension === 'yaml' or $extension === 'yml')) {
        $array = Yaml::parseFile($path);
        return $array;
    }
    return [];
}
