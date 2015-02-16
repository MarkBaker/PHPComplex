<?php
/**
 *
 * Function code for the complex tanh() function
 *
 * @author Michael A. Johnson
 * @License    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 * Returns the hyperbolic tangent of a complex number.
 *
 * @param $complex Complex number or a numeric value.
 * @return Complex|float The hyperbolic tangent of the complex argument.
 */
function tanh( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ( $complex->getImaginary() == 0.0 ) {
        $calc = clone $complex;
        $complex = sinh( $complex );
        $calc = cosh( $calc );
        $complex = $complex->divideBy( $calc );
        return $complex;
    }
}