<?php

namespace Complex;

include('../classes/Bootstrap.php');

echo "<h3>Function Examples</h3><br/>", PHP_EOL;

$functions = [
    'abs',
    'acos',
    'acosh',
    'acsc',
    'acsch',
    'argument',
    'asec',
    'asech',
    'asin',
    'asinh',
    'conjugate',
    'cos',
    'cosh',
    'csc',
    'csch',
    'exp',
    'inverse',
    'ln',
    'log2',
    'log10',
    'rho',
    'sec',
    'sech',
    'sin',
    'sinh',
    'sqrt',
    'theta',
    'acoth',
    'coth',
    'gudermannian',
    'haversine',
    'inversegudermannian',
    'inversehaversine',
    'tanh',
    'atanh'
];

for($real = -3.5; $real <= 3.5; $real += 0.5) {
    for($imaginary = -3.5; $imaginary <= 3.5; $imaginary += 0.5) {
        foreach($functions as $function) {
            $complexFunction = __NAMESPACE__ . '\\' . $function;
            $complex = new Complex($real, $imaginary);
            try {
                echo $function, '(', $complex, ') = ', $complexFunction($complex), "<br/>",PHP_EOL;
            } catch(\Exception $e) {
                echo $function, '(', $complex, ') ERROR: ', $e->getMessage(), "<br/>", PHP_EOL;
            }
        }
        echo "<br/>",PHP_EOL;
    }
}
