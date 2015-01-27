<?php

/**
 *
 * Function code for the complex rho() function
 *
 * @copyright  Copyright (c) 2013-2015 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 * Returns the rho of a complex number.
 * This is the distance/radius from the centrepoint to the representation of the number in polar coordinates.
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    \real            The rho value of the complex argument.
 * @throws    \Exception       If argument isn't a valid real or complex number.
 */
function rho($complex)
{
    $complex = Complex::validateComplexArgument($complex);

    return \sqrt(
        ($complex->getReal() * $complex->getReal()) +
        ($complex->getImaginary() * $complex->getImaginary())
    );
}
