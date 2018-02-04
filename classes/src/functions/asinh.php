<?php

/**
 *
 * Function code for the complex asinh() function
 *
 * @copyright  Copyright (c) 2013-2018 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    https://www.gnu.org/licenses/lgpl-3.0.html    LGPL 3.0
 */
namespace Complex;

/**
 * Returns the inverse hyperbolic sine of a complex number.
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    Complex          The inverse hyperbolic sine of the complex argument.
 * @throws    Exception        If argument isn't a valid real or complex number.
 */
function asinh($complex)
{
    $complex = Complex::validateComplexArgument($complex);

    if (($complex->getImaginary() == 0.0) && ($complex->getReal() > 1)) {
        return new Complex(\asinh($complex->getReal()), 0.0, $complex->getSuffix());
    }

    $asinh = clone $complex;
    $asinh = $asinh->reverse()
        ->invertReal();
    $asinh = asin($asinh);
    return $asinh->reverse()
        ->invertImaginary();
}
