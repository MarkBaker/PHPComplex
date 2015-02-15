<?php

/**
 *
 * Function code for the complex haversine() function
 *
 * @copyright  Copyright (c) 2013-2015 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @author     Michael A. Johnosn
 */
namespace Complex;

/**
 * Returns the haversine of a complex number.
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    Complex          The haversine of the complex argument.
 * @throws    \Exception       If argument isn't a valid real or complex number.
 * @throws    \InvalidArgumentException    If function would result in a division by zero
 */
function haversine( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ($complex->getImaginary() == 0.0) {
        $complex = $complex->divideBy( 2 );
        $complex = sin( $complex );
        $complex = $complex->multiply( $complex );
        return $complex;
    }
}