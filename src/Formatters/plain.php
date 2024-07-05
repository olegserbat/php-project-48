<?php

namespace Differ\Formatters;

function addPath(array $arr, string $postfix = ''): array
{
    $mapped = array_map(function ($key) use ($arr, $postfix) {
        $value = $arr[$key];
        if (isset($value['status'])) {
            if (is_array($value['arg']) && $value['status'] !== 'complex') {
                return [
                    $key => [
                        'status' => $value['status'],
                        'path' => $postfix . $key,
                        'arg' => addPath($value['arg'], $postfix . $key . ".")
                    ]
                ];
            } else {
                return [
                    $key => [
                        'status' => $value['status'],
                        'path' => $postfix . $key,
                        'arg' => $value['arg']
                    ]
                ];
            }
        } else {
            return [$key => $value];
        }
    }, array_keys($arr));

    return array_merge(...array_values($mapped));
}

function printSomeWord(mixed $data)
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

function printPlain(array $arr)
{
    return array_reduce($arr, function ($result, $value) {
        switch ($value['status']) {
            case '+':
                if (is_array($value['arg'])) {
                    $result = $result . "\n" . "Property '{$value['path']}' was added with value: [complex value]";
                } else {
                    $item = printSomeWord($value['arg']);
                    $result = $result . "\n" . "Property '{$value['path']}' was added with value: {$item}";
                }
                break;
            case '-':
                $result = $result . "\n" . "Property '{$value['path']}' was removed";
                break;
            case 'complex':
                if (!is_array($value['arg']['old']) and !is_array($value['arg']['new'])) {
                    $itemNew = printSomeWord($value['arg']['new']);
                    $itemOld = printSomeWord($value['arg']['old']);
                    $result = $result .
                        "\n" . "Property '{$value['path']}' was updated. From {$itemOld} to {$itemNew}";
                } elseif (is_array($value['arg']['old']) and !is_array($value['arg']['new'])) {
                    $itemNew = printSomeWord($value['arg']['new']);
                    $result = $result .
                        "\n" . "Property '{$value['path']}' was updated. From [complex value] to {$itemNew}";
                } elseif (!is_array($value['arg']['old']) and is_array($value['arg']['new'])) {
                    $itemOld = printSomeWord($value['arg']['old']);
                    $result = $result .
                        "\n" . "Property '{$value['path']}' was updated. From {$itemOld} to [complex value]";
                } else {
                    $result = $result .
                        "\n" . "Property '{$value['path']}' was updated. From [complex value] to [complex value]";
                }
                break;
            case 'no':
                $result = $result . printPlain($value['arg']);
        }
        return $result;
    }, '');
}
