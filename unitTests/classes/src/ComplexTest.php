<?php

namespace Complex;

use Complex\Complex as Complex;

class ComplexTest extends \PHPUnit_Framework_TestCase
{
    // Saved php.ini precision, so that we can adjust the setting
    private $precision;

    // Number of significant digits used for assertEquals
    private $significantDigits = 12;

    protected function setUp()
    {
        $this->precision = ini_set('precision', 16);
    }

    protected function tearDown()
    {
        ini_set('precision', $this->precision);
    }

    protected function getAssertionPrecision($value)
    {
        return pow(10, floor(\log10($value)) - $this->significantDigits + 1);
    }

    public function complexNumberAssertions($expected, $result)
    {
        if (is_numeric($expected)) {
            $this->assertEquals($expected, (string) $result, null, $this->getAssertionPrecision($expected));
        } else {
            $expected = new Complex($expected);
            $this->assertEquals($expected->getReal(), $result->getReal(), null, $this->getAssertionPrecision($expected->getReal()));
            $this->assertEquals($expected->getImaginary(), $result->getImaginary(), null, $this->getAssertionPrecision($expected->getImaginary()));
        }
    }

    public function testInstantiate()
    {
        $complexObject = new Complex();
        //    Must return an object...
        $this->assertTrue(is_object($complexObject));
        //    ... of the correct type
        $this->assertTrue(is_a($complexObject, __NAMESPACE__ . '\Complex'));

        $defaultComplexReal = $complexObject->getReal();
        $this->assertEquals(0.0, $defaultComplexReal);

        $defaultComplexImaginary = $complexObject->getImaginary();
        $this->assertEquals(0.0, $defaultComplexImaginary);

        $defaultComplexSuffix = $complexObject->getSuffix();
        $this->assertEquals('', $defaultComplexSuffix);
	}

    public function testInstantiateWithArgument()
    {
        $complexObject = new Complex(123.456);

        $defaultComplexReal = $complexObject->getReal();
        $this->assertEquals(123.456, $defaultComplexReal);

        $defaultComplexImaginary = $complexObject->getImaginary();
        $this->assertEquals(0.0, $defaultComplexImaginary);

        $defaultComplexSuffix = $complexObject->getSuffix();
        $this->assertEquals('', $defaultComplexSuffix);
	}

    public function testInstantiateWithArguments()
    {
        $complexObject = new Complex(1.2, 3.4);

        $defaultComplexReal = $complexObject->getReal();
        $this->assertEquals(1.2, $defaultComplexReal);

        $defaultComplexImaginary = $complexObject->getImaginary();
        $this->assertEquals(3.4, $defaultComplexImaginary);

        $defaultComplexSuffix = $complexObject->getSuffix();
        $this->assertEquals('i', $defaultComplexSuffix);
	}

    public function testInstantiateWithArray()
    {
        $complexObject = new Complex(
			array(
				2.3, 
				-4.5,
				'J'
			)
		);

        $defaultComplexReal = $complexObject->getReal();
        $this->assertEquals(2.3, $defaultComplexReal);

        $defaultComplexImaginary = $complexObject->getImaginary();
        $this->assertEquals(-4.5, $defaultComplexImaginary);

        $defaultComplexSuffix = $complexObject->getSuffix();
        $this->assertEquals('j', $defaultComplexSuffix);
	}

    public function testInstantiateWithString()
    {
        $complexObject = new Complex('-3.4+-5.6i');

        $defaultComplexReal = $complexObject->getReal();
        $this->assertEquals(-3.4, $defaultComplexReal);

        $defaultComplexImaginary = $complexObject->getImaginary();
        $this->assertEquals(-5.6, $defaultComplexImaginary);

        $defaultComplexSuffix = $complexObject->getSuffix();
        $this->assertEquals('i', $defaultComplexSuffix);
	}

    public function testInstantiateImaginary1()
    {
        $complexObject = new Complex('-i');

        $defaultComplexReal = $complexObject->getReal();
        $this->assertEquals(0, $defaultComplexReal);

        $defaultComplexImaginary = $complexObject->getImaginary();
        $this->assertEquals(-1, $defaultComplexImaginary);

        $defaultComplexSuffix = $complexObject->getSuffix();
        $this->assertEquals('i', $defaultComplexSuffix);
	}

    public function testInstantiateImaginary2()
    {
        $complexObject = new Complex('-2.5i');

        $defaultComplexReal = $complexObject->getReal();
        $this->assertEquals(0, $defaultComplexReal);

        $defaultComplexImaginary = $complexObject->getImaginary();
        $this->assertEquals(-2.5, $defaultComplexImaginary);

        $defaultComplexSuffix = $complexObject->getSuffix();
        $this->assertEquals('i', $defaultComplexSuffix);
	}

    public function testInstantiateImaginary3()
    {
        $complexObject = new Complex('2.5-i');

        $defaultComplexReal = $complexObject->getReal();
        $this->assertEquals(2.5, $defaultComplexReal);

        $defaultComplexImaginary = $complexObject->getImaginary();
        $this->assertEquals(-1, $defaultComplexImaginary);

        $defaultComplexSuffix = $complexObject->getSuffix();
        $this->assertEquals('i', $defaultComplexSuffix);
	}

    public function testFormat()
    {
        $complexObject = new Complex('-2.5i');
        $format = $complexObject->format();
        $this->assertEquals('-2.5i', $format);

        $complexObject = new Complex('-i');
        $format = $complexObject->format();
        $this->assertEquals('-i', $format);

        $complexObject = new Complex('-1+2i');
        $format = $complexObject->format();
        $this->assertEquals('-1+2i', $format);
	}

    /**
     * @expectedException Exception
     */
	public function testInvalidComplex()
	{
		$complex = new Complex('ABCDEFGHI');
	}

    /**
     * @dataProvider providerAdd
     */
	public function testAdd()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$complex->add(
			new Complex($args[1])
		);

        $expected = new Complex($args[2]);
        $this->assertEquals($expected->getReal(), $complex->getReal());
        $this->assertEquals($expected->getImaginary(), $complex->getImaginary());
	}

    /**
     * @dataProvider providerSubtract
     */
	public function testSubtract()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$complex->subtract(
			new Complex($args[1])
		);

        $expected = new Complex($args[2]);
        $this->assertEquals($expected->getReal(), $complex->getReal());
        $this->assertEquals($expected->getImaginary(), $complex->getImaginary());
	}

    /**
     * @dataProvider providerMultiply
     */
	public function testMultiply()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$complex->multiply(
			new Complex($args[1])
		);

        $expected = new Complex($args[2]);
        $this->assertEquals($expected->getReal(), $complex->getReal());
        $this->assertEquals($expected->getImaginary(), $complex->getImaginary());
	}

    /**
     * @dataProvider providerDivideBy
     */
	public function testDivideBy()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$complex->divideBy(
			new Complex($args[1])
		);

        $expected = new Complex($args[2]);
        $this->assertEquals($expected->getReal(), $complex->getReal());
        $this->assertEquals($expected->getImaginary(), $complex->getImaginary());
	}

    /**
     * @dataProvider providerDivideInto
     */
	public function testDivideInto()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$complex->divideInto(
			new Complex($args[1])
		);

        $expected = new Complex($args[2]);
        $this->assertEquals($expected->getReal(), $complex->getReal());
        $this->assertEquals($expected->getImaginary(), $complex->getImaginary());
	}

    /**
     * @dataProvider providerNegative
     */
	public function testNegative()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->negative();

        $this->complexNumberAssertions($args[1], $result);
	}

    /**
     * @dataProvider providerACos
     */
	public function testACos()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->acos();

        $this->complexNumberAssertions($args[1], $result);
	}

    /**
     * @dataProvider providerACosH
     */
	public function testACosH()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->acosh();

        $this->complexNumberAssertions($args[1], $result);
	}

    /**
     * @dataProvider providerASin
     */
	public function testASin()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->asin();

        $this->complexNumberAssertions($args[1], $result);
	}

    /**
     * @dataProvider providerASec
     */
	public function testASec()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->asec();

        $this->complexNumberAssertions($args[1], $result);
	}


    private $_oneComplexValueDataSets = array(
		array(12,		NULL,	    NULL),
		array(12.345,	NULL,	    NULL),
		array(0.12345,	NULL,	    NULL),
		array(12.345,	6.789,	    NULL),
		array(12.345,	-6.789,	    NULL),
		array(0.12345,	6.789,	    NULL),
		array(0.12345,	-6.789,	    NULL),
		array(0.12345,	0.6789, 	NULL),
		array(0.12345,	-0.6789,	NULL),
		array(-9.8765,	NULL,	    NULL),
		array(-0.98765,	NULL,	    NULL),
		array(-9.8765,	+4.321,	    NULL),
		array(-9.8765,	-4.321,	    NULL),
		array(-0.98765,	0.4321,	    NULL),
		array(-0.98765,	-0.4321,	NULL),
		array(0,		M_PI,		NULL),
		array(0,		-3.14159265358979324,   NULL),  // Shame we can't yet have dynamic expressions in property definitions
		array(0,		1,		    NULL),
		array(0,		-1,		    NULL),
		array(0,		0.123,		NULL),
		array(0,		-0.123,		NULL),
	);

	private function _formatOneArgumentTestResultArray($expectedResults)
	{
		$testValues = array();
		foreach($this->_oneComplexValueDataSets as $test => $dataSet) {
			$testValues[$test][] = $dataSet;
			$testValues[$test][] = $expectedResults[$test];
		}

		return $testValues;
	}

    private $_twoComplexValueDataSets = array(
		array(123,		NULL,	NULL,	456,		NULL,	NULL),
		array(123.456,	NULL,	NULL,	789.012,	NULL,	NULL),
		array(123.456,	78.90,	NULL,	-987.654,	-32.1,	NULL),
		array(123.456,	78.90,	NULL,	-987.654,	NULL,	NULL),
		array(-987.654,	-32.1,	NULL,	0,			1,		NULL),
		array(-987.654,	-32.1,	NULL,	0,			-1,		NULL),
	);

	private function _formatTwoArgumentTestResultArray($expectedResults)
	{
		$testValues = array();
		foreach($this->_twoComplexValueDataSets as $test => $dataSet) {
			$testValues[$test][] = array_slice($dataSet,0,3);
			$testValues[$test][] = array_slice($dataSet,3,3);
			$testValues[$test][] = $expectedResults[$test];
		}

		return $testValues;
	}

    public function providerAdd()
    {
		$expectedResults = array(
			579,
			912.468,
			'-864.198+46.8i',
			'-864.198+78.9i',
			'-987.654-31.1i',
			'-987.654-33.1i',
		);

		return $this->_formatTwoArgumentTestResultArray($expectedResults);
	}

    public function providerSubtract()
    {
		$expectedResults = array(
			-333,
			-665.556,
			'1111.11+111i',
			'1111.11+78.9i',
			'-987.654-33.1i',
			'-987.654-31.1i',
		);

		return $this->_formatTwoArgumentTestResultArray($expectedResults);
	}

    public function providerMultiply()
    {
		$expectedResults = array(
			56088,
			97408.265472,
			'-119399.122224-81888.8382i',
			'-121931.812224-77925.9006i',
			'32.1-987.654i',
			'-32.1+987.654i',
		);

		return $this->_formatTwoArgumentTestResultArray($expectedResults);
	}

    public function providerDivideBy()
    {
		$expectedResults = array(
			0.26973684210526,
			0.15646910313151,
			'-0.127461004165656-0.07574363265504158i',
			'-0.1249992406247532-0.0798862759630397i',
			'-32.1+987.654i',
			'32.1-987.654i',
		);

		return $this->_formatTwoArgumentTestResultArray($expectedResults);
	}

    public function providerDivideInto()
    {
		$expectedResults = array(
			3.7073170731707,
			6.3910381026439,
			'-5.798055462132258+3.44549131643853i',
			'-5.680072608981408+3.630100836319281i',
			'-3.287281241324573E-5-0.001011431921220928i',
			'3.287281241324573E-5+0.001011431921220928i',
		);

		return $this->_formatTwoArgumentTestResultArray($expectedResults);
	}

    /*
     */
    public function providerNegative()
    {
		$expectedResults = array(
			-12,
			-12.345,
			-0.12345,
            '-12.345-6.789i',
            '-12.345+6.789i',
            '-0.12345-6.789i',
            '-0.12345+6.789i',
            '-0.12345-0.6789i',
            '-0.12345+0.6789i',
			9.8765,
            0.98765,
			'9.8765-4.321i',
			'9.8765+4.321i',
			'0.98765-0.4321i',
			'0.98765+0.4321i',
            '-3.14159265358979324i',
            '3.14159265358979324i',
			'-i',
			'i',
            '-0.123i',
            '0.123i',
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[ArcCos[<VALUE>], 18]
     */
    public function providerACos()
    {
		$expectedResults = array(
			'3.17631318059165577i',
			'3.20475382161825604i',
            '1.44703059570184200',
			'0.50386235199241278-3.33784183956736074i',
			'0.50386235199241278+3.33784183956736074i',
			'1.55280848768351476-2.61399140081652779i',
			'1.55280848768351476+2.61399140081652779i',
			'1.46865136582657190-0.63823568781287892i',
			'1.46865136582657190+0.63823568781287892i',
            '3.14159265358979324-2.98073255621495518i',
            2.98426811978550341,
            '2.72759273898886477-3.06941431940712748i',
            '2.72759273898886477+3.06941431940712748i',
            '2.49959220942165618-0.67028138559198731i',
            '2.49959220942165618+0.67028138559198731i',
            '1.57079632679489662-1.86229574331084822i',
            '1.57079632679489662+1.86229574331084822i',
            '1.57079632679489662-0.88137358701954303i',
            '1.57079632679489662+0.88137358701954303i',
            '1.57079632679489662-0.12269194815825956i',
            '1.57079632679489662+0.12269194815825956i',
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[ArcCosH[<VALUE>], 18]
     */
    public function providerACosH()
    {
		$expectedResults = array(
			3.17631318059165577,
			3.20475382161825604,
            '1.44703059570184200i',
			'3.33784183956736074+0.50386235199241278i',
			'3.33784183956736074-0.50386235199241278i',
			'2.61399140081652779+1.55280848768351476i',
			'2.61399140081652779-1.55280848768351476i',
			'0.63823568781287892+1.46865136582657190i',
			'0.63823568781287892-1.46865136582657190i',
            '2.98073255621495518+3.14159265358979324i',
            '2.98426811978550341i',
            '3.06941431940712748+2.72759273898886477i',
            '3.06941431940712748-2.72759273898886477i',
            '0.67028138559198731+2.49959220942165618i',
            '0.67028138559198731-2.49959220942165618i',
            '1.86229574331084822+1.57079632679489662i',
            '1.86229574331084822-1.57079632679489662i',
            '0.88137358701954303+1.57079632679489662i',
            '0.88137358701954303-1.57079632679489662i',
            '0.12269194815825956+1.57079632679489662i',
            '0.12269194815825956-1.57079632679489662i',
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[ArcSin[<VALUE>], 18]
     */
    public function providerASin()
    {
		$expectedResults = array(
			'1.57079632679489662-3.17631318059165577i',
			'1.57079632679489662-3.20475382161825604i',
            0.123765731093054622,
            '1.06693397480248384+3.33784183956736074i',
            '1.06693397480248384-3.33784183956736074i',
            '0.01798783911138186+2.61399140081652779i',
            '0.01798783911138186-2.61399140081652779i',
            '0.102144960968324714+0.638235687812878915i',
            '0.102144960968324714-0.638235687812878915i',
            '-1.57079632679489662+2.98073255621495518i',
            -1.41347179299060679,
            '-1.15679641219396815+3.06941431940712748i',
            '-1.15679641219396815-3.06941431940712748i',
            '-0.928795882626759563+0.670281385591987313i',
            '-0.928795882626759563-0.670281385591987313i',
            '1.86229574331084822i',
            '-1.86229574331084822i',
            '0.881373587019543025i',
            '-0.881373587019543025i',
            '0.122691948158259558i',
            '-0.122691948158259558i',
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[ArcSec[<VALUE> Radians], 18]
     */
    public function providerASec()
    {
		$expectedResults = array(
			1.48736624018428161,
            1.48970302082660277,
            '2.78123430803937039i',
            '1.50859800830252214+0.03426287528025610i',
            '1.50859800830252214-0.03426287528025610i',
            '1.56814734798028957+0.14672193818647115i',
            '1.56814734798028957-0.14672193818647115i',
            '1.42248128431339558+1.16195623593418560i',
            '1.42248128431339558-1.16195623593418560i',
            1.67222057013667903,
            '3.14159265358979324-0.15797756885066499i',
            '1.65582341680235061+0.03730682535518739i',
            '1.65582341680235061-0.03730682535518739i',
            '2.40822472454593001+0.53025304749856957i',
            '2.40822472454593001-0.53025304749856957i',
            '1.57079632679489662+0.31316588045086838i',
            '1.57079632679489662-0.31316588045086838i',
            '1.57079632679489662+0.88137358701954303i',
            '1.57079632679489662-0.88137358701954303i',
            '1.57079632679489662+2.79247907463123116i',
            '1.57079632679489662-2.79247907463123116i',
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

}
