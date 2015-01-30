<?php

/**
 *
 * Function code for the complex cot() function
 *
 * @copyright  Copyright (c) 2013-2015 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 * Returns the cotangent of a complex number.
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    Complex          The cotangent of the complex argument.
 * @throws    \Exception       If argument isn't a valid real or complex number.
 * @throws    \InvalidArgumentException    If function would result in a division by zero
 */
function cot($complex)
{
    $complex = Complex::validateComplexArgument($complex);

    return inverse(tan($complex));
}
