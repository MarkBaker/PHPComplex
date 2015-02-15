<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 12-Feb-15
 * Time: 7:56 AM
 */
namespace Complex;
function gudermannian( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ($complex->getImaginary() == 0.0) {
        $complex = exp( $complex );
        $complex = atan( $complex );
        $complex = $complex->multiply( 2 );
        $complex = $complex->add( -( M_PI/2 ) );
        return $complex;
    }
}