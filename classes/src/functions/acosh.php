<?php

/**
 *
 * Function code for the complex acosh() function
 *
 * @copyright  Copyright (c) 2013-2018 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    https://www.gnu.org/licenses/lgpl-3.0.html    LGPL 3.0
 */
namespace Complex;

/**
 * Returns the inverse hyperbolic cosine of a complex number.
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    Complex          The inverse hyperbolic cosine of the complex argument.
 * @throws    Exception        If argument isn't a valid real or complex number.
 */
function acosh($complex)
{
    $complex = Complex::validateComplexArgument($complex);

    if (($complex->getImaginary() == 0.0) && ($complex->getReal() > 1)) {
        return new Complex(\acosh($complex->getReal()), 0.0, $complex->getSuffix());
    }

    $acosh = acos($complex)
        ->reverse();
    if ($acosh->getReal() < 0.0) {
        $acosh = $acosh->invertReal();
    }

    return $acosh;
}
