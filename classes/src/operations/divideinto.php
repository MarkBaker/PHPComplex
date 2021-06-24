<?php

/**
 *
 * Function code for the complex division operation
 *
 * @copyright  Copyright (c) 2013-2018 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    https://opensource.org/licenses/MIT    MIT
 */
namespace Complex;

/**
 * Divides two or more complex numbers
 *
 * @param     array of string|integer|float|Complex    $complexValues   The numbers to divide
 * @return    Complex
 */
if (!function_exists(__NAMESPACE__ . '\\divideinto')) {
    function divideinto(...$complexValues): Complex
    {
        return Operations::divideinto(...$complexValues);
    }
}
