<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 12-Feb-15
 * Time: 7:56 AM
 */
namespace Complex;

function tanh( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ($complex->getImaginary() == 0.0) {
        $calc = clone $complex;
        $complex = sinh( $complex );
        $calc = cosh( $calc );
        $complex = $complex->divideBy( $calc );
        return $complex;
    }
}