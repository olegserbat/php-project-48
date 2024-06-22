<?php

namespace Differ\Formatters;

function formatters(array $diff, string $formatName = 'stylish')
{
    switch ($formatName) {
        case 'stylish':
            return "{" . printStylish($diff) . "\n" . "}";
        case 'plain':
            return printPlain(addPath($diff));
        case 'json':
            return json_encode($diff, JSON_PRETTY_PRINT);
        default:
            return 'Format is not correct! Please, enter correct format';
    }
}
