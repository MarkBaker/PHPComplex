<?php
/**
 *
 * Function code for the complex haversine() function
 *
 * @author Michael A. Johnson
 * @License    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 *
 * Returns the haversine function of a complex number.
 *
 * @param $complex Complex number or a numeric value.
 * @return Complex|float The haversine of the complex argument.
 * @throws \Exception f argument isn't a valid real or complex number.
 */
function haversine( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ( $complex->getImaginary() == 0.0 ) {
        $complex = $complex->divideBy( 2 );
        $complex = sin( $complex );
        $complex = $complex->multiply( $complex );
        return $complex;
    }
}