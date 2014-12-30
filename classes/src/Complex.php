<?php

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
    const EULER = 2.71828182845904523536;

    protected $realPart = 0.0;

    protected $imaginaryPart = 0.0;

    protected $suffix;


    protected static function parseComplex($complexNumber)
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
            if (abs($this->imaginaryPart) != 1.0) {
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

    private function validateComplexArgument($complex)
    {
        if (is_scalar($complex)) {
            $complex = new Complex($complex);
        } elseif (!is_object($complex) || !($complex instanceof Complex)) {
            throw new \Exception('COMPLEX: Value "'.$complex.'" is not a valid complex number');
        }
        if ($complex->getSuffix() !== '' &&
            $this->suffix !== '' &&
            $complex->getSuffix() !== $this->suffix) {
            throw new \Exception('COMPLEX: Inconsistent suffix');
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
        $complex = $this->validateComplexArgument($complex);

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
        $complex = $this->validateComplexArgument($complex);

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
        $complex = $this->validateComplexArgument($complex);

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
        $complex = $this->validateComplexArgument($complex);

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
        $complex = $this->validateComplexArgument($complex);

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
     * Returns the absolute value (modulus) of this complex number
     *
     * @return    float
     */
    public function abs()
    {
        return sqrt(
            ($this->realPart * $this->realPart) +
            ($this->imaginaryPart * $this->imaginaryPart)
        );
    }

    /**
     * Returns the theta of this complex number, i.e. the angle in radians
     * from the real axis to the representation of the number in polar coordinates.
     *
     * @return    float
     */
    public function theta()
    {
        if ($this->realPart == 0.0) {
            if ($this->imaginaryPart == 0.0) {
                return 0.0;
            } elseif ($this->imaginaryPart < 0.0) {
                return M_PI / -2;
            }
            return M_PI / 2;
        } elseif ($this->realPart > 0.0) {
            return atan($this->imaginaryPart / $this->realPart);
        } elseif ($this->imaginaryPart < 0.0) {
            return -(M_PI - atan(abs($this->imaginaryPart) / abs($this->realPart)));
        }
        return M_PI - atan($this->imaginaryPart / abs($this->realPart));
    }

    /**
     * Synonym for theta()
     *
     * @see    theta
     */
    public function argument()
    {
        return $this->theta();
    }

    /**
     * Returns the rho of this complex number, i.e. the distance/radius
     * from the centrepoint to the representation of the number in polar coordinates.
     *
     * @return    float
     */
    public function rho()
    {
        return sqrt(
            ($this->realPart * $this->realPart) +
            ($this->imaginaryPart * $this->imaginaryPart)
        );
    }

    /**
     * Returns the complex conjugate of this complex number
     *
     * @return    Complex
     */
    public function conjugate()
    {
        return new Complex(
            $this->realPart,
            -1 * $this->imaginaryPart,
            $this->suffix
        );
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
     * Returns the inverse of this complex number
     *
     * @return    Complex
     */
    public function inverse()
    {
        return $this->divideInto();
    }

    /**
     * Returns the cosine of this complex number
     *
     * @return    Complex
     */
    public function cos()
    {
        if ($this->imaginaryPart == 0.0) {
            return new Complex(cos($this->realPart), 0.0, $this->suffix);
        }

        $complex = new Complex(
            cos($this->realPart) * cosh($this->imaginaryPart),
            sin($this->realPart) * sinh($this->imaginaryPart),
            $this->suffix
        );
        return $complex->conjugate();
    }

    /**
     * Returns the hyperbolic cosine of this complex number
     *
     * @return    Complex
     */
    public function cosh()
    {
        if ($this->imaginaryPart == 0.0) {
            return new Complex(cosh($this->realPart), 0.0, $this->suffix);
        }
        return new Complex(
            cosh($this->realPart) * cos($this->imaginaryPart),
            sinh($this->realPart) * sin($this->imaginaryPart),
            $this->suffix
        );
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
        $t = $t->sqrt();
        $v = new Complex(
            $this->realPart - $t->getImaginary(),
            $this->imaginaryPart + $t->getReal()
        );
        $z = $v->ln();

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
     * Returns the sine of this complex number
     *
     * @return    Complex
     */
    public function sin()
    {
        if ($this->imaginaryPart == 0.0) {
            return new Complex(sin($this->realPart), 0.0, $this->suffix);
        }
        return new Complex(
            sin($this->realPart) * cosh($this->imaginaryPart),
            cos($this->realPart) * sinh($this->imaginaryPart),
            $this->suffix
        );
    }

    /**
     * Returns the hyperbolic sine of this complex number
     *
     * @return    Complex
     */
    public function sinh()
    {
        if ($this->imaginaryPart == 0.0) {
            return new Complex(sinh($this->realPart), 0.0, $this->suffix);
        } else {
            return new Complex(
                sinh($this->realPart) * cos($this->imaginaryPart),
                cosh($this->realPart) * sin($this->imaginaryPart),
                $this->suffix
            );
        }
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
        $t = $t->sqrt();
        $v = new Complex(
            $t->getReal() - $this->imaginaryPart,
            $t->getImaginary() + $this->realPart
        );
        $z = $v->ln();
        return new Complex(
            $z->getImaginary(),
            -1 * $z->getReal()
        );
    }

    /**
     * Returns the secant of this complex number
     *
     * @return    Complex
     */
    public function sec()
    {
        $complex = clone $this;
        return $complex->cos()
            ->inverse();
    }

    /**
     * Returns the hyperbolic secant of this complex number
     *
     * @return    Complex
     */
    public function sech()
    {
        $complex = clone $this;
        return $complex->cosh()->inverse();
    }

    /**
     * Returns the inverse secant of this complex number
     *
     * @return    Complex
     */
    public function asec()
    {
        $complex = clone $this;
        return $complex->inverse()->acos();
    }

    /**
     * Returns the inverse hyperbolic secant of this complex number
     *
     * @return    Complex
     */
    public function asech()
    {
        $complex = clone $this;
        return $complex->inverse()->acosh();
    }

    /**
     * Returns the cosecant of this complex number
     *
     * @return    Complex
     */
    public function csc()
    {
        $complex = clone $this;
        return $complex->sin()->inverse();
    }

    /**
     * Returns the hyperbolic cosecant of this complex number
     *
     * @return    Complex
     */
    public function csch()
    {
        $complex = clone $this;
        return $complex->sinh()->inverse();
    }

    /**
     * Returns the inverse cosecant of this complex number
     *
     * @return    Complex
     */
    public function acsc()
    {
        $complex = clone $this;
        return $complex->inverse()->asin();
    }

    /**
     * Returns the inverse hyperbolic cosecant of this complex number
     *
     * @return    Complex
     */
    public function acsch()
    {
        $complex = clone $this;
        return $complex->inverse()->asinh();
    }

    /**
     * Returns the square root of this complex number
     *
     * @return    Complex
     */
    public function sqrt()
    {
        $theta = $this->theta();
        $delta1 = cos($theta / 2);
        $delta2 = sin($theta / 2);
        $rho = sqrt($this->rho());

        return new Complex($delta1 * $rho, $delta2 * $rho, $this->suffix);
    }

    /**
     * Returns the exponential of this complex number
     *
     * @return    Complex
     */
    public function exp()
    {
        if (($this->realPart == 0.0) && (abs($this->imaginaryPart) == M_PI)) {
            return new Complex(-1.0, 0.0);
        }

        $rho = exp($this->realPart);
 
        return new Complex($rho * cos($this->imaginaryPart), $rho * sin($this->imaginaryPart), $this->suffix);
    }

    /**
     * Returns the natural logarithm of this complex number
     *
     * @return Complex
     * @throws \InvalidArgumentException
     */
    public function ln()
    {
        if (($this->realPart == 0.0) && ($this->imaginaryPart == 0.0)) {
            throw new \InvalidArgumentException();
        }

        return new Complex(
            log($this->rho()),
            $this->theta(),
            $this->suffix
        );
    }

    /**
     * Returns the common logarithm (base 10) of this complex number
     *
     * @return Complex
     * @throws \InvalidArgumentException
     */
    public function log10()
    {
        if (($this->realPart == 0.0) && ($this->imaginaryPart == 0.0)) {
            throw new \InvalidArgumentException();
        } elseif (($this->realPart > 0.0) && ($this->imaginaryPart == 0.0)) {
            return new Complex(log10($this->realPart), 0.0, $this->suffix);
        }

        $complex = new Complex(
            $this->realPart,
            $this->imaginaryPart,
            $this->suffix
        );
        return $complex->ln()
            ->multiply(log10(self::EULER));
    }

    /**
     * Returns the base-2 logarithm of this complex number
     *
     * @return Complex
     * @throws \InvalidArgumentException
     */
    public function log2()
    {
        if (($this->realPart == 0.0) && ($this->imaginaryPart == 0.0)) {
            throw new \InvalidArgumentException();
        } elseif (($this->realPart > 0.0) && ($this->imaginaryPart == 0.0)) {
            return new Complex(log($this->realPart, 2), 0.0, $this->suffix);
        }

        $complex = new Complex(
            $this->realPart,
            $this->imaginaryPart,
            $this->suffix
        );
        return $complex->ln()
            ->multiply(log(self::EULER, 2));
    }
}
