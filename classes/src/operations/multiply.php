<?php

/**
 *
 * Function code for the complex multiplication operation
 *
 * @copyright  Copyright (c) 2013-2018 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    https://opensource.org/licenses/MIT    MIT
 */
namespace Complex;

/**
 * Multiplies two or more complex numbers
 *
 * @param     array of string|integer|float|Complex    $complexValues   The numbers to multiply
 * @return    Complex
 */
if (!function_exists(__NAMESPACE__ . '\\multiply')) {
    function multiply(...$complexValues): Complex
    {
        return Operations::multiply(...$complexValues);
    }
}
