<?php

/**
 *
 * Function code for the complex addition operation
 *
 * @copyright  Copyright (c) 2013-2018 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    https://www.gnu.org/licenses/lgpl-3.0.html    LGPL 3.0
 */
namespace Complex;

    /**
     * Adds two or more complex numbers
     *
     * @param     array of string|integer|float|Complex    $complexValues   The numbers to add
     * @return    Complex
     */
function add(...$complexValues)
{
    if (count($complexValues) < 2) {
        throw new \Exception('This function requires at least 2 arguments');
    }

    $base = array_shift($complexValues);
    $result = clone Complex::validateComplexArgument($base);

    foreach ($complexValues as $complex) {
        $complex = Complex::validateComplexArgument($complex);

        $real = $result->getReal() + $complex->getReal();
        $imaginary = $result->getImaginary() + $complex->getImaginary();

        $result = new Complex(
            $real,
            $imaginary,
            ($imaginary == 0.0) ? null : max($result->getSuffix(), $complex->getSuffix())
        );
    }

    return $result;
}
