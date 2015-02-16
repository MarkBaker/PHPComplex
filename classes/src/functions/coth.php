<?php
/**
 *
 * Function code for the complex coth() function
 *
 * @author Michael A. Johnson
 * @License    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 *
 * Returns the hyperbolic cotangent of a complex number.
 *
 * @param $complex Complex number or a numeric value.
 * @return Complex|float|null The hyperbolic cotangent of the complex argument.
 * @throws \Exception f argument isn't a valid real or complex number.
 */
function coth( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ( $complex->getImaginary() == 0.0 ) {
        $calc = clone $complex;
        $complex = cosh( $complex );
        $calc = sinh( $calc );

        if ( $calc->getReal() != 0 ) {
            $complex = $complex->divideBy( $calc );
            return $complex;
        } else {
            return null;
        }
    }
}