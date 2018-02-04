<?php

/**
 *
 * Function code for the complex negative() function
 *
 * @copyright  Copyright (c) 2013-2018 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    https://www.gnu.org/licenses/lgpl-3.0.html    LGPL 3.0
 */
namespace Complex;

/**
 * Returns the negative of a complex number.
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    float            The negative value of the complex argument.
 * @throws    Exception        If argument isn't a valid real or complex number.
 *
 * @see    rho
 *
 */
function negative($complex)
{
    $complex = Complex::validateComplexArgument($complex);

    return new Complex(
        -1 * $complex->getReal(),
        -1 * $complex->getImaginary(),
        $complex->getSuffix()
    );
}
