<?php
/**
 *
 * Function code for the complex acoth() function
 *
 * @author Michael A. Johnson
 * @License    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 *
 * Returns the inverse hyperbolic cotangent of a complex number.
 *
 * @param $complex Complex number or a numeric value.
 * @return Complex|float The inverse hyperbolic cotangent of the complex argument.
 * @throws \Exception f argument isn't a valid real or complex number.
 */
function acoth( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ( $complex->getImaginary() == 0.0 ) {
        if ( ( $complex->getReal() == -1 ) || ( $complex->getReal() == 1 ) ) {
            return INF;
        } else {
            $calc = clone $complex;
            $complex = $complex->add( 1 );
            $calc = $calc->subtract( 1 );
            $complex = $complex->divideBy( $calc );
            $complex = ln( $complex );
            $complex = $complex->divideBy( 2 );
            return $complex;
        }
    }
}