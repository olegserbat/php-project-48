<?php

namespace Differ\Formatters;

function addPath(array $arr, string $postfix = ''): array
{
    $result = array_map(function ($value) use ($postfix) {
        if (isset($value['key'])) {
            if (is_array($value['arg']) && $value['status'] !== 'complex') {
                return
                    [
                        'key' => $value['key'],
                        'status' => $value['status'],
                        'path' => $postfix . $value['key'],
                        'arg' => addPath($value['arg'], "{$postfix}{$value['key']}.")

                    ];
            } else {
                return [
                    'key' => $value['key'],
                    'status' => $value['status'],
                    'path' => $postfix . $value['key'],
                    'arg' => $value['arg']
                ];
            }
        } else {
            return $value;
        }
    }, $arr);
    return $result;
}

function printPlain(array $arr)
{
    return implode('', array_map(function ($value) {
        switch ($value['status']) {
            case '+':
                if (is_array($value['arg'])) {
                    return "\n" . "Property '{$value['path']}' was added with value: [complex value]";
                } else {
                    $item = printSomeWordForPlain($value['arg']);
                    return "\n" . "Property '{$value['path']}' was added with value: {$item}";
                }
            case '-':
                return "\n" . "Property '{$value['path']}' was removed";
            case 'complex':
                if (!is_array($value['arg']['old']) and !is_array($value['arg']['new'])) {
                    $itemNew = printSomeWordForPlain($value['arg']['new']);
                    $itemOld = printSomeWordForPlain($value['arg']['old']);
                    return "\n" . "Property '{$value['path']}' was updated. From {$itemOld} to {$itemNew}";
                } elseif (is_array($value['arg']['old']) and !is_array($value['arg']['new'])) {
                    $itemNew = printSomeWordForPlain($value['arg']['new']);
                    return "\n" . "Property '{$value['path']}' was updated. From [complex value] to {$itemNew}";
                } elseif (!is_array($value['arg']['old']) and is_array($value['arg']['new'])) {
                    $itemOld = printSomeWordForPlain($value['arg']['old']);
                    return "\n" . "Property '{$value['path']}' was updated. From {$itemOld} to [complex value]";
                } else {
                    return "\n" . "Property '{$value['path']}' was updated. From [complex value] to [complex value]";
                }
            case 'no':
                return printPlain($value['arg']);
        }
    }, $arr));
}

function printSomeWordForPlain(mixed $data)
{
    if ($data === false) {
        return 'false';
    } elseif ($data === true) {
        return 'true';
    } elseif ($data === null) {
        return 'null';
    } elseif ($data === 0) {
        return '0';
    } else {
        return "'{$data}'";
    }
}
