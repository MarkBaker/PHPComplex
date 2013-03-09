<?php

class Complex {

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

	public function __toString()
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

}

