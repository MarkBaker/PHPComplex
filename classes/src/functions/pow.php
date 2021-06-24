<?php

/**
 *
 * Function code for the complex pow() function
 *
 * @copyright  Copyright (c) 2013-2018 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    https://opensource.org/licenses/MIT    MIT
 */
namespace Complex;

/**
 * Returns a complex number raised to a power.
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @param     float|integer    $power      The power to raise this value to
 * @return    Complex          The complex argument raised to the real power.
 * @throws    Exception        If the power argument isn't a valid real
 */
if (!function_exists(__NAMESPACE__ . '\\pow')) {
    function pow($complex, $power): Complex
    {
        return Functions::pow($complex, $power);
    }
}
