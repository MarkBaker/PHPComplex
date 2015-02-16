<?php
/**
 *
 * Function code for the complex atanh() function
 *
 * @author Michael A. Johnson
 * @License    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 *
 * Returns the inverse hyperbolic tangent of a complex number.
 *
 * @param $complex Complex number or a numeric value.
 * @return Complex|float The inverse hyperbolic tangent of the complex argument.
 * @throws \Exception f argument isn't a valid real or complex number.
 */
function atanh( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ( $complex->getImaginary() == 0.0 ) {
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
