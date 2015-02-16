<?php
/**
 *
 * Function code for the complex gudermannian() function
 *
 * @author Michael A. Johnson
 * @License    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 *
 * Returns the gudermannian of a complex number.
 *
 * @param $complex Complex number or a numeric value.
 * @return Complex|float The gudermannian of the complex argument.
 * @throws \Exception f argument isn't a valid real or complex number.
 */
function gudermannian( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ( $complex->getImaginary() == 0.0 ) {
        $complex = exp( $complex );
        $complex = atan( $complex );
        $complex = $complex->multiply( 2 );
        $complex = $complex->add( -( M_PI/2 ) );
        return $complex;
    }
}