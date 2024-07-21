<?php

namespace Differ\Formatters;

use function Differ\MakeDiff\printSomeWord;

function printStylish(array $arr, string $indent = ''): array
{
    $arrayStrings = array_map(function ($value) use ($indent) {
        switch ($value['status']) {
            case '+':
            case '-':
                if (is_array($value['arg'])) {
                    return printNonAnilizeArray($value['arg'], $indent, $value['status'], $value['key']);
                }
                return printString($value['arg'], $indent, $value['status'], $value['key']);
            case 'no':
            case 'both':
                if (is_array($value['arg'])) {
                    return printArray($value['arg'], $indent, ' ', $value['key']);
                }
                return printString($value['arg'], $indent, ' ', $value['key']);
            case 'complex':
                if (is_array($value['arg']['old'])) {
                    $param1 = printNonAnilizeArray($value['arg']['old'], $indent, '-', $value['key']);
                } else {
                    $param1 = printString($value['arg']['old'], $indent, '-', $value['key']);
                }
                if (is_array($value['arg']['new'])) {
                    $param2 = printNonAnilizeArray($value['arg']['new'], $indent, '+', $value['key']);
                } else {
                    $param2 = printString($value['arg']['new'], $indent, '+', $value['key']);
                }
                return "$param1" . "$param2";
        }
    }, $arr);
    return $arrayStrings;
}

function printNonAnilizeArray(array $value, string $indent, string $status, string $key): string
{
    return "\n" . "{$indent}  {$status} " . "{$key}: {" .
        implode('', printArrayWithoutStatus($value, $indent .
            str_repeat(' ', 4))) .
        "\n" . $indent . str_repeat(' ', 4) . "}";
}

function printString(mixed $value, string $indent, string $status, string $key): string
{
    $arg = printSomeWord($value);
    return "\n" . "$indent" . "  {$status} {$key}: {$arg}";
}

function printArray(array $value, string $indent, string $status, string $key): string
{
    return "\n" . "{$indent}  {$status} " . "{$key}: {" .
        implode('', printStylish($value, $indent
            . str_repeat(' ', 4))) .
        "\n" . "$indent" . str_repeat(' ', 4) . "}";
}

function printArrayWithoutStatus(array $value, string $indent): array
{
    $result = array_map(function ($key, $value) use ($indent) {
        if (!is_array($value)) {
            $arg = printSomeWord($value);
            return "\n" . "$indent" . "    {$key}: {$arg}";
        } else {
            return "\n" . "{$indent}    " . "{$key}: {" .
                implode('', printArrayWithoutStatus($value, $indent .
                    str_repeat(' ', 4))) .
                "\n" . $indent . str_repeat(' ', 4) . "}";
        }
    }, array_keys($value), $value);
    return $result;
}
