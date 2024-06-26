<?php

namespace Differ\Formatters;

use function Differ\MakeDiff\printSomeWord;

function getStatus(array $arr)
{
    return $arr['status'];
}

function getArg(array $arr)
{
    return $arr['arg'];
}

function printString(string $indent, string $status, string $key, string $arg)
{
    return ("\n" . "$indent" . "  {$status} {$key}: {$arg}");
}

function printArray(string $indent, string $status, string $key, string|array $value)
{
    return "\n" . "{$indent}  {$status} " . "{$key}: {" .
        printStylish($value, $indent .
            str_repeat(' ', 4)) . "\n" . "$indent" . str_repeat(' ', 4) . "}";
}

function printStylish(array $arr, string $indent = '')
{
    $result = '';
    foreach ($arr as $key => $value) {
        if (isset($value['status'])) {
            if (!is_array(getArg($value)) or getStatus($value) === 'complex') {
                switch (getStatus($value)) {
                    case ('+'):
                    case ('-'):
                        $arg = printSomeWord(getArg($value));
                        $result = $result . printString($indent, getStatus($value), $key, $arg);
                        break;
                    case 'both':
                        $arg = printSomeWord(getArg($value));
                        $result = $result . printString($indent, ' ', $key, $arg);
                        break;
                    case 'complex':
                        if (!is_array($value['arg']['old'])) {
                            $oldArg = printSomeWord($value['arg']['old']);
                            $result = $result . printString($indent, '-', $key, $oldArg);
                        } else {
                            $result = $result . printArray($indent, '-', $key, $value['arg']['old']);
                        }
                        if (!is_array($value['arg']['new'])) {
                            $newArg = printSomeWord($value['arg']['new']);
                            $result = $result . printString($indent, '+', $key, $newArg);
                        } else {
                            $result = $result . printArray($indent, '+', $key, $value['arg']['new']);
                        }
                        break;
                }
            } else {
                switch (getStatus($value)) {
                    case 'no':
                        $result = $result . printArray($indent, ' ', $key, getArg($value));
                        break;
                    case '-':
                        $result = $result . printArray($indent, '-', $key, getArg($value));
                        break;
                    case '+':
                        $result = $result . printArray($indent, '+', $key, getArg($value));
                        break;
                }
            }
        } else {
            if (is_array($value)) {
                $result = $result . printArray($indent, ' ', $key, $value);
            } else {
                $arg = printSomeWord($value);
                $result = $result . printString($indent, ' ', $key, $arg);
            }
        }
    }
    return $result;
}
