<?php

/**
 *
 * Function code for the complex atanh() function
 *
 * @copyright  Copyright (c) 2013-2015 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 * Returns the inverse hyperbolic tangent of a complex number.
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    Complex          The inverse hyperbolic tangent of the complex argument.
 * @throws    \Exception       If argument isn't a valid real or complex number.
 */
function atanh($complex)
{
    $complex = Complex::validateComplexArgument($complex);

    $imaginary = $complex->getImaginary();
    if ($imaginary == 0.0 ) {
        $real = $complex->getReal();
        if ($real > -1.0 && $real < 1.0) {
            return new Complex(\atanh($real), 0.0, $complex->getSuffix());
        } else {
            return new Complex(\atanh(1 / $real), (($real < 0.0) ? M_PI_2 : -1 * M_PI_2));
        }
    }

    $iComplex = clone $complex;
    $iComplex->invertImaginary();
    $iComplex->reverse();
    $result = atan($iComplex);
    $result->invertReal();
    $result->reverse();
    return $result;
}
