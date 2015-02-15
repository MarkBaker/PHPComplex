<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 12-Feb-15
 * Time: 7:55 AM
 */
namespace Complex;

/**
 * @param $complex
 * @return Complex
 * @throws \Exception
 */
function inversehaversine( $complex )
{
    $complex = Complex::validateComplexArgument( $complex );

    if ( $complex->getImaginary() == 0.0 ) {
        if (($complex->getReal() >= 0.0) && ($complex->getReal() <= 1.0)) {
            $complex = sqrt( $complex );
            $complex = asin( $complex );
            $complex = $complex->multiply( 2 );
            return $complex;
        }
    }
}