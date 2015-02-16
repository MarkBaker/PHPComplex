<?php
/**
 *
 * Function code for the complex inversehaversine() function
 *
 * @author Michael A. Johnson
 * @License    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 *
 * Returns the inverse haversine of a complex number.
 *
 * @param $complex Complex number or a numeric value.
 * @return Complex|float The inverse haversine of the complex argument.
 * @throws \Exception f argument isn't a valid real or complex number.
 */
function inversehaversine( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ( $complex->getImaginary() == 0.0 ) {
        if ( ( $complex->getReal() >= 0.0 ) && ( $complex->getReal() <= 1.0 ) ) {
            $complex = sqrt( $complex );
            $complex = asin( $complex );
            $complex = $complex->multiply( 2 );
            return $complex;
        }
    }
}