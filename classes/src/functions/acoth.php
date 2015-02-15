<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 12-Feb-15
 * Time: 7:56 AM
 */
namespace Complex;

function acoth( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ($complex->getImaginary() == 0.0) {
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