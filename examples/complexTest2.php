<?php

namespace Complex;

include('../classes/Bootstrap.php');

echo 'Function Examples', PHP_EOL;

$complexValues = [
    123,
    -123,
    [123, 456],
    [123, 456, 'j'],
    [123, -456],
    [-123, 456],
    [-123, -456],
    '1.23e-4--2.34e-5i',
    '-1.23e-4--2.34e-5i',
    '-1.23e-4-2.34e-5i',
    '1.23e-4-2.34e-5i',
    [0, 123],
    [0, -123],
];

$functions = [
    'conjugate',
    'cos',
    'sin',
    'rho',
    'theta',
];

foreach($functions as $function) {
    $complexFunction = __NAMESPACE__ . '\\' . $function;
    foreach($complexValues as $complexValue) {
        $complex = new Complex($complexValue);
        echo $function, '(', $complex, ') is ', $complexFunction($complex), PHP_EOL;
    }
    echo PHP_EOL;
}
