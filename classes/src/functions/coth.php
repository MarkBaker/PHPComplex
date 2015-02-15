<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 12-Feb-15
 * Time: 7:56 AM
 */
namespace Complex;

function coth( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ($complex->getImaginary() == 0.0) {
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