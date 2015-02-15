<?php

/**
 *
 * Function code for the complex atan() function
 *
 * @copyright  Copyright (c) 2013-2015 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

//include_once 'Math/Complex.php';
//include_once 'Math/ComplexOp.php';

/**
 * Returns the inverse tangent of a complex number.
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    Complex          The inverse tangent of the complex argument.
 * @throws    \Exception       If argument isn't a valid real or complex number.
 * @throws    \InvalidArgumentException    If function would result in a division by zero
 */
function atanh( $complex )
{
    $complex = Complex::validateComplexArgument($complex);

    if ($complex->getImaginary() == 0.0) {
        if ( ( $complex->getReal() == -1 )  || ( $complex->getReal() == 1 ) ){
            return INF;
        } else {
            $calc = clone $complex;

            $complex->add( 1 );
            $complex = ln( $complex );

            $calc = $calc->multiply( -1 );
            $calc = $calc->add( 1 );
            $calc = ln( $calc );

            $complex = $complex->subtract( $calc );
            $complex = $complex->divideBy( 2 );

            return $complex;
        }
    }
}
