<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 12-Feb-15
 * Time: 7:56 AM
 */
namespace Complex;

function inversegudermannian( $complex )
{
    $complex = Complex::validateComplexArgument($complex);

    if ($complex->getImaginary() == 0.0) {
        $complex = $complex->divideBy( 2 );
        $complex = $complex->add( M_PI/4 );
        $complex = tan( $complex );
        $complex = ln( $complex );
        return $complex;
    }
}