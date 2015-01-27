<?php

/**
 *
 * Function code for the complex acosh() function
 *
 * @copyright  Copyright (c) 2013-2015 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 * Returns the inverse hyperbolic cosine of a complex number.
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    Complex          The inverse hyperbolic cosine of the complex argument.
 * @throws    \Exception       If argument isn't a valid real or complex number.
 */
function acosh($complex)
{
    $complex = Complex::validateComplexArgument($complex);

    if (($complex->getImaginary() == 0.0) && ($complex->getReal() > 1)) {
        return new Complex(\acosh($complex->getReal()), 0.0, $complex->getSuffix());
    }

    $acosh = acos($complex);
    $acosh->reverse();
    if ($acosh->getReal() < 0.0) {
        $acosh->invertReal();
    }

    return $acosh;
}
