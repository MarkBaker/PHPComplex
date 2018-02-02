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
function multiply(...$complexValues)
{
    if(count($complexValues) < 2) {
        throw new \Exception('This function requires at least 2 arguments');
    }

    $base = array_shift($complexValues);
    $result = clone $base;
    foreach($complexValues as $complex) {
        $result->multiply($complex);
    }
    return $result;
}
