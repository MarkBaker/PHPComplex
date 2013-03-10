<?php

class Complex {

	const EULER = 2.71828182845904523536;

	protected $_realPart = 0.0;

	protected $_imaginaryPart = 0.0;

	protected $_suffix;


	protected static function _parseComplex($complexNumber)
	{
		//	Test for real number, with no imaginary part
		if (is_numeric($complexNumber))
			return array( $complexNumber, 0, NULL );

		//	Fix silly human errors
		if (strpos($complexNumber,'+-') !== FALSE)
			$complexNumber = str_replace('+-','-',$complexNumber);
		if (strpos($complexNumber,'-+') !== FALSE)
			$complexNumber = str_replace('-+','-',$complexNumber);
		if (strpos($complexNumber,'++') !== FALSE)
			$complexNumber = str_replace('++','+',$complexNumber);
		if (strpos($complexNumber,'--') !== FALSE)
			$complexNumber = str_replace('--','+',$complexNumber);

		//	Basic validation of string, to parse out real and imaginary parts, and any suffix
		$validComplex = preg_match('/^([\-\+]?(\d+\.?\d*|\d*\.?\d+)([Ee][\-\+]?[0-2]?\d{1,3})?)([\-\+]?(\d+\.?\d*|\d*\.?\d+)([Ee][\-\+]?[0-2]?\d{1,3})?)?(([\-\+]?)([ij]?))$/ui',$complexNumber,$complexParts);

		if (!$validComplex) {
			//	Neither real nor imaginary part, so test to see if we actually have a suffix
			$validComplex = preg_match('/^([\-\+]?)([ij])$/ui',$complexNumber,$complexParts);
			if (!$validComplex) {
				throw new Exception('COMPLEX: Invalid complex number');
			}
			//	We have a suffix, so set the real to 0, the imaginary to either 1 or -1 (as defined by the sign)
			$imaginary = 1;
			if ($complexParts[1] === '-') {
				$imaginary = 0 - $imaginary;
			}
			return array(0, $imaginary, $complexParts[2]);
		}

		//	If we don't have an imaginary part, identify whether it should be +1 or -1...
		if (($complexParts[4] === '') && ($complexParts[9] !== '')) {
			if ($complexParts[7] !== $complexParts[9]) {
				$complexParts[4] = 1;
				if ($complexParts[8] === '-') {
					$complexParts[4] = -1;
				}
			//	... or if we have only the real and no imaginary part (in which case our real should be the imaginary)
			} else {
				$complexParts[4] = $complexParts[1];
				$complexParts[1] = 0;
			}
		}

		//	Return real and imaginary parts and suffix as an array, and set a default suffix if user input lazily
		return array( $complexParts[1],
					  $complexParts[4],
					  !empty($complexParts[9]) ? $complexParts[9] : 'i'
					);
	}	//	function _parseComplex()


	public function __construct($realPart = 0.0, $imaginaryPart = NULL, $suffix = 'i')
	{
		if ($imaginaryPart === NULL) {
			if (is_array($realPart)) {
				//	We have an array of (potentially) real and imaginary parts, and any suffix
				list ($realPart, $imaginaryPart, $suffix) = array_values($realPart) + array(0.0, 0.0, 'i');
				if ($suffix === NULL) $suffix = 'i';
			} elseif((is_string($realPart)) || (is_numeric($realPart))) {
				//	We've been given a string to parse to extract the real and imaginary parts, and any suffix
				list ($realPart, $imaginaryPart, $suffix) = self::_parseComplex($realPart);
			}
		}

		//	Set parsed values in our properties
		$this->_realPart = (float) $realPart;
		$this->_imaginaryPart = (float) $imaginaryPart;
		$this->_suffix = strtolower($suffix);
	}

	public function getReal()
	{
		return $this->_realPart;
	}

	public function getImaginary()
	{
		return $this->_imaginaryPart;
	}

	public function getSuffix()
	{
		return $this->_suffix;
	}

	public function format()
	{
		$str = "";
		if ($this->_imaginaryPart != 0.0) {
			if (abs($this->_imaginaryPart) != 1.0) {
				$str .= $this->_imaginaryPart . $this->_suffix;
			} else {
				$str .= (($this->_imaginaryPart < 0.0) ? '-' : '') . $this->_suffix;
			}
		}
		if ($this->_realPart != 0.0) {
			if (($str) && ($this->_imaginaryPart > 0.0))
				$str = "+" . $str;
			$str = $this->_realPart . $str;
		}
		if (!$str)
			$str = "0.0";

		return $str;
	}

	public function __toString()
	{
		return $this->format();
	}


	private function _validateComplexArgument($complex)
	{
		if (is_scalar($complex)) {
			$complex = new Complex($complex);
		} elseif(!is_object($complex) || !($complex instanceof Complex)) {
			throw new Exception('Value "'.$complex.'" is not a valid complex number');
		}
		if ($complex->getSuffix() !== '' &&
			$this->_suffix !== '' &&
			$complex->getSuffix() !== $this->_suffix) {
			throw new Exception('Inconsistent suffix');
		}

		return $complex;
	}

	/**
	 * Adds a value to this complex number
	 *
	 * @param	string|integer|float|Complex		$complex	The number to add
	 * @return	Complex
	 */
	public function add($complex = 0.0)
	{
		$complex = $this->_validateComplexArgument($complex);

		$this->_realPart += $complex->getReal();
		$this->_imaginaryPart += $complex->getImaginary();

		return $this;
	}

	/**
	 * Subtracts a value from this complex number
	 *
	 * @param	string|integer|float|Complex		$complex	The number to subtract
	 * @return	Complex
	 */
	public function subtract($complex = 0.0)
	{
		$complex = $this->_validateComplexArgument($complex);

		$this->_realPart -= $complex->getReal();
		$this->_imaginaryPart -= $complex->getImaginary();

		return $this;
	}

	/**
	 * Multiplies this complex number by a value
	 *
	 * @param	string|integer|float|Complex		$complex	The number to multiply by
	 * @return	Complex
	 */
	public function multiply($complex = 1.0)
	{
		$complex = $this->_validateComplexArgument($complex);

		$_realPart =
			($this->getReal() * $complex->getReal()) -
			($this->getImaginary() * $complex->getImaginary());
		$_imaginaryPart =
			($this->getReal() * $complex->getImaginary()) +
			($this->getImaginary() * $complex->getReal());
		$this->_realPart = $_realPart;
		$this->_imaginaryPart = $_imaginaryPart;

		return $this;
	}

	/**
	 * Divides this complex number by a value
	 *
	 * @param	string|integer|float|Complex		$complex	The number to divide by
	 * @return	Complex
	 */
	public function divideBy($complex = 1.0)
	{
		$complex = $this->_validateComplexArgument($complex);

		$d1 =
			($this->getReal() * $complex->getReal()) +
			($this->getImaginary() * $complex->getImaginary());
		$d2 =
			($this->getImaginary() * $complex->getReal()) -
			($this->getReal() * $complex->getImaginary());
		$d3 =
			($complex->getReal() * $complex->getReal()) +
			($complex->getImaginary() * $complex->getImaginary());

		$this->_realPart = $d1 / $d3;
		$this->_imaginaryPart = $d2 / $d3;

		return $this;
	}

	/**
	 * Divides this complex number into a value
	 *
	 * @param	string|integer|float|Complex		$complex	The number to divide into
	 * @return	Complex
	 */
	public function divideInto($complex = 1.0)
	{
		$complex = $this->_validateComplexArgument($complex);

		$d1 =
			($complex->getReal() * $this->getReal()) +
			($complex->getImaginary() * $this->getImaginary());
		$d2 =
			($complex->getImaginary() * $this->getReal()) -
			($complex->getReal() * $this->getImaginary());
		$d3 =
			($this->getReal() * $this->getReal()) +
			($this->getImaginary() * $this->getImaginary());

		$this->_realPart = $d1 / $d3;
		$this->_imaginaryPart = $d2 / $d3;

		return $this;
	}

	/**
	 * Returns the absolute value (modulus) of this complex number
	 *
	 * @return	float
	 */
	public function abs()
	{
		return sqrt(
			($this->_realPart * $this->_realPart) +
			($this->_imaginaryPart * $this->_imaginaryPart)
		);
	}

	/**
	 * Returns the argument theta of this complex number, i.e. the angle in radians from the real
	 * axis to the representation of the number in polar coordinates.
	 *
	 * @return	float
	 */
	public function argument()
	{
		if ($this->_realPart == 0.0) {
			if ($this->_imaginaryPart == 0.0) {
				return 0.0;
			} elseif($this->_imaginaryPart < 0.0) {
				return M_PI / -2;
			} else {
				return M_PI / 2;
			}
		} elseif ($this->_realPart > 0.0) {
			return atan($this->_imaginaryPart / $this->_realPart);
		} elseif ($this->_imaginaryPart < 0.0) {
			return 0 - (M_PI - atan(abs($this->_imaginaryPart) / abs($this->_realPart)));
		} else {
			return M_PI - atan($this->_imaginaryPart / abs($this->_realPart));
		}
	}

	/**
	 * Returns the complex conjugate of this complex number
	 *
	 * @return	Complex
	 */
	public function conjugate()
	{
		return new Complex(
			$this->_realPart,
			0 - $this->_imaginaryPart,
			$this->_suffix
		);
	}

	/**
	 * Returns the cosine of this complex number
	 *
	 * @return	Complex
	 */
	public function cos()
	{
		if ($this->_imaginaryPart == 0.0) {
			return new Complex(
				cos($this->_realPart),
				0.0,
				$this->_suffix
			);
		} else {
			$complex = new Complex(
				cos($this->_realPart) * cosh($this->_imaginaryPart),
				sin($this->_realPart) * sinh($this->_imaginaryPart),
				$this->_suffix
			);
			return $complex->conjugate();
		}
	}

	/**
	 * Returns the sine of this complex number
	 *
	 * @return	Complex
	 */
	public function sin()
	{
		if ($this->_imaginaryPart == 0.0) {
			return new Complex(
				sin($this->_realPart),
				0.0,
				$this->_suffix
			);
		} else {
			return new Complex(
				sin($this->_realPart) * cosh($this->_imaginaryPart),
				cos($this->_realPart) * sinh($this->_imaginaryPart),
				$this->_suffix
			);
		}
	}

	/**
	 * Returns the square root of this complex number
	 *
	 * @return	Complex
	 */
	public function sqrt() {
		$theta = $this->argument();
		$d1 = cos($theta / 2);
		$d2 = sin($theta / 2);
		$r = sqrt(
			sqrt(
				($this->_realPart * $this->_realPart) + 
				($this->_imaginaryPart * $this->_imaginaryPart)
			)
		);

		return new Complex(
			$d1 * $r,
			$d2 * $r,
			$this->_suffix
		);
	}

	/**
	 * Returns the natural logarithm of this complex number
	 *
	 * @return	Complex
	 */
	public function ln() {
		if (($this->_realPart == 0.0) && ($this->_imaginaryPart == 0.0)) {
			return new Complex(
				0.0,
				0.0,
				$this->_suffix
			);
		}

		$logR = log(
			sqrt(
				($this->_realPart * $this->_realPart) + 
				($this->_imaginaryPart * $this->_imaginaryPart)
			)
		);
		$t = $this->argument();

			return new Complex(
				$logR,
				$t,
				$this->_suffix
			);
	}	//	function IMLN()

	/**
	 * Returns the common logarithm (base 10) of this complex number
	 *
	 * @return	Complex
	 */
	public  function log10() {
		if (($this->_realPart == 0.0) && ($this->_imaginaryPart == 0.0)) {
			return new Complex(
				0.0,
				0.0,
				$this->_suffix
			);
		} elseif (($this->_realPart > 0.0) && ($this->_imaginaryPart == 0.0)) {
			return new Complex(
				log10($this->_realPart),
				0.0,
				$this->_suffix
			);
		}

		$complex = new Complex(
			$this->_realPart,
			$this->_imaginaryPart,
			$this->_suffix
		);
		$complex = $complex->ln();
		return $complex->multiply(log10(self::EULER));
	}

	/**
	 * Returns the base-2 logarithm of this complex number
	 *
	 * @return	Complex
	 */
	public  function log2() {
		if (($this->_realPart == 0.0) && ($this->_imaginaryPart == 0.0)) {
			return new Complex(
				0.0,
				0.0,
				$this->_suffix
			);
		} elseif (($this->_realPart > 0.0) && ($this->_imaginaryPart == 0.0)) {
			return new Complex(
				log($this->_realPart,2),
				0.0,
				$this->_suffix
			);
		}

		$complex = new Complex(
			$this->_realPart,
			$this->_imaginaryPart,
			$this->_suffix
		);
		$complex = $complex->ln();
		return $complex->multiply(log(self::EULER,2));
	}	//	function IMLOG2()


}

