<?php

/**
 *
 * Function code for the complex abs() function
 *
 * @copyright  Copyright (c) 2013-2015 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 * Returns the absolute value (modulus) of a complex number.
 * Also known as the rho of the complex number, i.e. the distance/radius
 *   from the centrepoint to the representation of the number in polar coordinates.
 *
 * This function is a synonym for rho()
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    \real            The absolute (or rho) value of the complex argument.
 * @throws    \Exception       If argument isn't a valid real or complex number.
 *
 * @see    rho
 *
 */
function abs($complex)
{
    return rho($complex);
}
