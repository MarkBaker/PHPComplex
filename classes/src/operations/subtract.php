<?php

/**
 *
 * Function code for the complex subtraction operation
 *
 * @copyright  Copyright (c) 2013-2018 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    https://opensource.org/licenses/MIT    MIT
 */
namespace Complex;

/**
 * Subtracts two or more complex numbers
 *
 * @param     array of string|integer|float|Complex    $complexValues   The numbers to subtract
 * @return    Complex
 */
if (!function_exists(__NAMESPACE__ . '\\subtract')) {
    function subtract(...$complexValues): Complex
    {
        return Operations::subtract(...$complexValues);
    }
}
