<?php

/**
 *
 * Class for the management of Complex numbers
 *
 * @package Complex
 * @copyright  Copyright (c) 2013-2015 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
namespace Complex;

/**
 * Complex Number object.
 *
 * @package Complex
 * @copyright  Copyright (c) 2013-2014 Mark Baker (https://github.com/MarkBaker/PHPComplex)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
class Complex
{
    /**
     * @constant    Euler's Number.
     */
    const EULER = 2.7182818284590452353602874713526624977572;

    /**
     * @var    float    $realPart    The value of of this complex number on the real plane.
     */
    protected $realPart = 0.0;

    /**
     * @var    float    $imaginaryPart    The value of of this complex number on the imaginary plane.
     */
    protected $imaginaryPart = 0.0;

    /**
     * @var    string    $suffix    The suffix for this complex number (i or j).
     */
    protected $suffix;


    private static function parseComplex($complexNumber)
    {
        // Test for real number, with no imaginary part
        if (is_numeric($complexNumber)) {
            return array($complexNumber, 0, null);
        }

        // Fix silly human errors
        $complexNumber = str_replace(
            array('+-', '-+', '++', '--'),
            array('-', '-', '+', '+'),
            $complexNumber
        );

        // Basic validation of string, to parse out real and imaginary parts, and any suffix
        $validComplex = preg_match(
            '/^([\-\+]?(\d+\.?\d*|\d*\.?\d+)([Ee][\-\+]?[0-2]?\d{1,3})?)([\-\+]?(\d+\.?\d*|\d*\.?\d+)([Ee][\-\+]?[0-2]?\d{1,3})?)?(([\-\+]?)([ij]?))$/ui',
            $complexNumber,
            $complexParts
        );

        if (!$validComplex) {
            // Neither real nor imaginary part, so test to see if we actually have a suffix
            $validComplex = preg_match('/^([\-\+]?)([ij])$/ui', $complexNumber, $complexParts);
            if (!$validComplex) {
                throw new \Exception('COMPLEX: Invalid complex number');
            }
            // We have a suffix, so set the real to 0, the imaginary to either 1 or -1 (as defined by the sign)
            $imaginary = 1;
            if ($complexParts[1] === '-') {
                $imaginary = 0 - $imaginary;
            }
            return array(0, $imaginary, $complexParts[2]);
        }

        // If we don't have an imaginary part, identify whether it should be +1 or -1...
        if (($complexParts[4] === '') && ($complexParts[9] !== '')) {
            if ($complexParts[7] !== $complexParts[9]) {
                $complexParts[4] = 1;
                if ($complexParts[8] === '-') {
                    $complexParts[4] = -1;
                }
            } else {
                // ... or if we have only the real and no imaginary part
                //  (in which case our real should be the imaginary)
                $complexParts[4] = $complexParts[1];
                $complexParts[1] = 0;
            }
        }

        // Return real and imaginary parts and suffix as an array, and set a default suffix if user input lazily
        return array(
            $complexParts[1],
            $complexParts[4],
            !empty($complexParts[9]) ? $complexParts[9] : 'i'
        );
    }


    public function __construct($realPart = 0.0, $imaginaryPart = null, $suffix = 'i')
    {
        if ($imaginaryPart === null) {
            if (is_array($realPart)) {
                // We have an array of (potentially) real and imaginary parts, and any suffix
                list ($realPart, $imaginaryPart, $suffix) = array_values($realPart) + array(0.0, 0.0, 'i');
                if ($suffix === null) {
                    $suffix = 'i';
                }
            } elseif ((is_string($realPart)) || (is_numeric($realPart))) {
                // We've been given a string to parse to extract the real and imaginary parts, and any suffix
                list($realPart, $imaginaryPart, $suffix) = self::parseComplex($realPart);
            }
        }

        // Set parsed values in our properties
        $this->realPart = (float) $realPart;
        $this->imaginaryPart = (float) $imaginaryPart;
        $this->suffix = strtolower($suffix);
    }

    /**
     * Gets the real part of this complex number
     *
     * @return Float
     */
    public function getReal()
    {
        return $this->realPart;
    }

    /**
     * Gets the imaginary part of this complex number
     *
     * @return Float
     */
    public function getImaginary()
    {
        return $this->imaginaryPart;
    }

    /**
     * Gets the suffix of this complex number
     *
     * @return String
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    public function format()
    {
        $str = "";
        if ($this->imaginaryPart != 0.0) {
            if (\abs($this->imaginaryPart) != 1.0) {
                $str .= $this->imaginaryPart . $this->suffix;
            } else {
                $str .= (($this->imaginaryPart < 0.0) ? '-' : '') . $this->suffix;
            }
        }
        if ($this->realPart != 0.0) {
            if (($str) && ($this->imaginaryPart > 0.0)) {
                $str = "+" . $str;
            }
            $str = $this->realPart . $str;
        }
        if (!$str) {
            $str = "0.0";
        }

        return $str;
    }

    public function __toString()
    {
        return $this->format();
    }

    /**
     * Validates whether the argument is a valid complex number, converting scalar or array values if possible
     *
     * @param     mixed    $complex   The value to validate
     * @return    Complex
     * @throws    \Exception    If the argument isn't a Complex number or cannot be converted to one
     */
    public static function validateComplexArgument($complex)
    {
        if (is_scalar($complex) || is_array($complex)) {
            $complex = new Complex($complex);
        } elseif (!is_object($complex) || !($complex instanceof Complex)) {
            throw new \Exception('COMPLEX: Value "'.$complex.'" is not a valid complex number');
        }

        return $complex;
    }

    /**
     * Adds a value to this complex number, modifying the value of this instance
     *
     * @param    string|integer|float|Complex    $complex   The number to add
     * @return    Complex
     */
    public function add($complex = 0.0)
    {
        $complex = self::validateComplexArgument($complex);

        $this->realPart += $complex->getReal();
        $this->imaginaryPart += $complex->getImaginary();

        return $this;
    }

    /**
     * Subtracts a value from this complex number, modifying the value of this instance
     *
     * @param    string|integer|float|Complex    $complex   The number to subtract
     * @return    Complex
     */
    public function subtract($complex = 0.0)
    {
        $complex = self::validateComplexArgument($complex);

        $this->realPart -= $complex->getReal();
        $this->imaginaryPart -= $complex->getImaginary();

        return $this;
    }

    /**
     * Multiplies this complex number by a value, modifying the value of this instance
     *
     * @param    string|integer|float|Complex    $complex   The number to multiply by
     * @return    Complex
     */
    public function multiply($complex = 1.0)
    {
        $complex = self::validateComplexArgument($complex);

        $realPart = ($this->getReal() * $complex->getReal()) -
            ($this->getImaginary() * $complex->getImaginary());
        $imaginaryPart = ($this->getReal() * $complex->getImaginary()) +
            ($this->getImaginary() * $complex->getReal());
        $this->realPart = $realPart;
        $this->imaginaryPart = $imaginaryPart;

        return $this;
    }

    /**
     * Divides this complex number by a value, modifying the value of this instance
     *
     * @param    string|integer|float|Complex    $complex   The number to divide by
     * @return    Complex
     */
    public function divideBy($complex = 1.0)
    {
        $complex = self::validateComplexArgument($complex);

        $delta1 = ($this->getReal() * $complex->getReal()) +
            ($this->getImaginary() * $complex->getImaginary());
        $delta2 = ($this->getImaginary() * $complex->getReal()) -
            ($this->getReal() * $complex->getImaginary());
        $delta3 = ($complex->getReal() * $complex->getReal()) +
            ($complex->getImaginary() * $complex->getImaginary());

        $this->realPart = $delta1 / $delta3;
        $this->imaginaryPart = $delta2 / $delta3;

        return $this;
    }

    /**
     * Divides this complex number into a value, modifying the value of this instance
     *
     * @param    string|integer|float|Complex    $complex   The number to divide into
     * @return    Complex
     */
    public function divideInto($complex = 1.0)
    {
        $complex = self::validateComplexArgument($complex);

        $delta1 = ($complex->getReal() * $this->getReal()) +
            ($complex->getImaginary() * $this->getImaginary());
        $delta2 = ($complex->getImaginary() * $this->getReal()) -
            ($complex->getReal() * $this->getImaginary());
        $delta3 = ($this->getReal() * $this->getReal()) +
            ($this->getImaginary() * $this->getImaginary());

        $this->realPart = $delta1 / $delta3;
        $this->imaginaryPart = $delta2 / $delta3;

        return $this;
    }

    /**
     * Returns the negative of this complex number
     *
     * @return    Complex
     */
    public function negative()
    {
        return new Complex(
            -1 * $this->realPart,
            -1 * $this->imaginaryPart,
            $this->suffix
        );
    }

    /**
     * Returns the reverse of this complex number
     *
     * @return    Complex
     */
    public function reverse()
    {
        $t = $this->realPart;
        $this->realPart = $this->imaginaryPart;
        $this->imaginaryPart = $t;
    }

    public function invertImaginary()
    {
        $this->imaginaryPart *= -1;
    }

    public function invertReal()
    {
        $this->realPart *= -1;
    }

    /**
     * Returns the inverse cosine of this complex number
     *
     * @return    Complex
     */
    public function acos()
    {
        $v = clone $this;
        $v = $v->multiply($this);
        $t = new Complex(1.0);
        $t = $t->subtract($v);
        $t = sqrt($t);
        $v = new Complex(
            $this->realPart - $t->getImaginary(),
            $this->imaginaryPart + $t->getReal()
        );
        $z = ln($v);

        return new Complex(
            $z->getImaginary(),
            -1 * $z->getReal()
        );
    }

    /**
     * Returns the inverse hyperbolic cosine of this complex number
     *
     * @return    Complex
     */
    public function acosh()
    {
        if (($this->imaginaryPart == 0.0) && ($this->realPart > 1)) {
            return new Complex(acosh($this->realPart), 0.0, $this->suffix);
        }
        $z = $this->acos();
        $z->reverse();
        if ($z->getReal() < 0.0) {
            $z->invertReal();
        }
        return $z;
    }

    /**
     * Returns the inverse sine of this complex number
     *
     * @return    Complex
     */
    public function asin()
    {
        $v = clone $this;
        $v = $v->multiply($this);
        $t = new Complex(1.0);
        $t = $t->subtract($v);
        $t = sqrt($t);
        $v = new Complex(
            $t->getReal() - $this->imaginaryPart,
            $t->getImaginary() + $this->realPart
        );
        $z = ln($v);
        return new Complex(
            $z->getImaginary(),
            -1 * $z->getReal()
        );
    }

    /**
     * Returns the inverse secant of this complex number
     *
     * @return    Complex
     */
    public function asec()
    {
        $complex = clone $this;
        return inverse($complex)->acos();
    }

    /**
     * Returns the inverse hyperbolic secant of this complex number
     *
     * @return    Complex
     */
    public function asech()
    {
        $complex = clone $this;
        return inverse($complex)->acosh();
    }

    /**
     * Returns the hyperbolic cosecant of this complex number
     *
     * @return    Complex
     */
    public function csch()
    {
        $complex = clone $this;
        return inverse(sinh($complex));
    }

    /**
     * Returns the inverse cosecant of this complex number
     *
     * @return    Complex
     */
    public function acsc()
    {
        $complex = clone $this;
        return inverse($complex)->asin();
    }

    /**
     * Returns the inverse hyperbolic cosecant of this complex number
     *
     * @return    Complex
     */
    public function acsch()
    {
        $complex = clone $this;
        return inverse($complex)->asinh();
    }
}
