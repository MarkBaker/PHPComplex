<?php

/**
 *
 * Function code for the complex conjugate() function
 *
 * @copyright  Copyright (c) 2013-2018 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    https://www.gnu.org/licenses/lgpl-3.0.html    LGPL 3.0
 */
namespace Complex;

/**
 * Returns the complex conjugate of a complex number
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    Complex          The conjugate of the complex argument.
 * @throws    Exception        If argument isn't a valid real or complex number.
 */
function conjugate($complex)
{
    $complex = Complex::validateComplexArgument($complex);

    return new Complex(
        $complex->getReal(),
        -1 * $complex->getImaginary(),
        $complex->getSuffix()
    );
}
