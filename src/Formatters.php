<?php

namespace Differ\Formatters;

function formatters(array $diff, string $formatName = 'stylish')
{
    switch ($formatName) {
        case 'stylish':
            return "{" . printStylish($diff) . "\n" . "}";
            break;
        case 'plain':
            return printPlain(addPath($diff));
            break;
        case 'json':
            return json_encode($diff, JSON_PRETTY_PRINT);
            break;
        default:
            return 'Format is not correct! Please, enter correct format';
    }
}
