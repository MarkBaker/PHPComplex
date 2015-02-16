<?php
/**
 *
 * Function code for the complex inversegudermannian() function
 *
 * @author Michael A. Johnson
 * @License    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 *
 * Returns the inverse gudermannian of a complex number.
 *
 * @param $complex Complex number or a numeric value.
 * @return Complex|float The inverse gudermannian of the complex argument.
 * @throws \Exception f argument isn't a valid real or complex number.
 */
function inversegudermannian( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ( $complex->getImaginary() == 0.0 ) {
        $complex = $complex->divideBy( 2 );
        $complex = $complex->add( M_PI/4 );
        $complex = tan( $complex );
        $complex = ln( $complex );
        return $complex;
    }
}