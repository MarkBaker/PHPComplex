<?php

/**
 *
 * Function code for the complex cos() function
 *
 * @copyright  Copyright (c) 2013-2018 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    https://www.gnu.org/licenses/lgpl-3.0.html    LGPL 3.0
 */
namespace Complex;

/**
 * Returns the cosine of a complex number.
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    Complex          The cosine of the complex argument.
 * @throws    Exception        If argument isn't a valid real or complex number.
 */
function cos($complex)
{
    $complex = Complex::validateComplexArgument($complex);

    if ($complex->getImaginary() == 0.0) {
        return new Complex(\cos($complex->getReal()), 0.0, $complex->getSuffix());
    }

    return conjugate(
        new Complex(
            \cos($complex->getReal()) * \cosh($complex->getImaginary()),
            \sin($complex->getReal()) * \sinh($complex->getImaginary()),
            $complex->getSuffix()
        )
    );
}
