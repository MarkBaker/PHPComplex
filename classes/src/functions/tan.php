<?php

/**
 *
 * Function code for the complex tan() function
 *
 * @package Complex
 * @copyright  Copyright (c) 2013-2015 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 * Returns the tangent of a complex number.
 *
 * @param     Complex|mixed    $complex    Complex number or a numeric value.
 * @return    Complex          The tangent of the complex argument.
 * @throws    \Exception       If argument isn't a valid real or complex number.
 */
function tan($complex)
{
    $complex = Complex::validateComplexArgument($complex);

    if ($complex->getImaginary() == 0.0) {
        return new Complex(\tan($complex->getReal()), 0.0, $complex->getSuffix());
    }

    $aValue = $complex->getReal();
    $bValue = $complex->getImaginary();
    $divisor = 1 + \pow(\tan($aValue), 2) * \pow(\tanh($bValue), 2);
    if ($divisor == 0.0) {
        throw new Exception('Division by zero while calculating \Complex\tan()');
    }

    return new Complex(
        \pow(sech($bValue)->getReal(), 2) * \tan($aValue) / $divisor,
        \pow(sec($aValue)->getReal(), 2) * \tanh($bValue) / $divisor,
        $complex->getSuffix()
    );
}
