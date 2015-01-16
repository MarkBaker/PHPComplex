<?php

/**
 *
 * Function code for the complex csch() function
 *
 * @package Complex
 * @copyright  Copyright (c) 2013-2015 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 * Returns the hyperbolic cosecant of a complex number.
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    Complex          The hyperbolic cosecant of the complex argument.
 * @throws    \Exception       If argument isn't a valid real or complex number.
 * @throws    \InvalidArgumentException    If function would result in a division by zero
 */
function csch($complex)
{
    $complex = Complex::validateComplexArgument($complex);

    if ($complex->getReal() == 0.0 && $complex->getImaginary() == 0.0) {
        return INF;
    }

    return inverse(sinh($complex));
}
