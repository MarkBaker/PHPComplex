<?php

/**
 *
 * Function code for the complex addition operation
 *
 * @copyright  Copyright (c) 2013-2018 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    https://opensource.org/licenses/MIT    MIT
 */
namespace Complex;

/**
 * Adds two or more complex numbers
 *
 * @param     array of string|integer|float|Complex    $complexValues   The numbers to add
 * @return    Complex
 */
if (!function_exists(__NAMESPACE__ . '\\add')) {
    function add(...$complexValues): Complex
    {
        return Operations::add(...$complexValues);
    }
}
