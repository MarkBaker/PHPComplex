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
        return pow(10, floor(log10($value)) - $this->significantDigits + 1);
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
     * @dataProvider providerAbs
     */
	public function testAbs()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->abs();

        $this->assertEquals($args[1], $result);
	}

    /**
     * @dataProvider providerTheta
     */
	public function testTheta()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->theta();

        $this->assertEquals($args[1], $result);
	}

	public function testArgument()
	{
		$complex = new Complex(0.0);
		$result = $complex->argument();

        $this->assertEquals(0.0, $result);
	}

    /**
     * @dataProvider providerRho
     */
	public function testRho()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->rho();

        $this->assertEquals($args[1], $result);
	}

    /**
     * @dataProvider providerConjugate
     */
	public function testConjugate()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->conjugate();

        $this->complexNumberAssertions($args[1], $result);
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
     * @dataProvider providerCos
     */
	public function testCos()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->cos();

        $this->complexNumberAssertions($args[1], $result);
	}

    /**
     * @dataProvider providerCosH
     */
	public function testCosH()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->cosh();

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
     * @dataProvider providerSin
     */
	public function testSin()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->sin();

        $this->complexNumberAssertions($args[1], $result);
	}

    /**
     * @dataProvider providerSinH
     */
	public function testSinH()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->sinh();

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
     * @dataProvider providerSec
     */
	public function testSec()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->sec();

        $this->complexNumberAssertions($args[1], $result);
	}

    /**
     * @dataProvider providerSecH
     */
	public function testSecH()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->sech();

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

    /**
     * @dataProvider providerCsc
     */
	public function testCoSec()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->csc();

        $this->complexNumberAssertions($args[1], $result);
	}

    /**
     * @dataProvider providerSqrt
     */
	public function testSqrt()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->sqrt();

        $this->complexNumberAssertions($args[1], $result);
	}

    /**
     * @dataProvider providerLn
     */
	public function testLn()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->ln();

        $this->complexNumberAssertions($args[1], $result);
	}

    /**
     * @dataProvider providerExp
     */
	public function testExp()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->exp();

        $this->complexNumberAssertions($args[1], $result);
	}

    /**
     * @expectedException InvalidArgumentException
     */
	public function testLnZero()
	{
		$complex = new Complex(0);
		$result = $complex->ln();
	}

    /**
     * @dataProvider providerLog10
     */
	public function testLog10()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->log10();

        $this->complexNumberAssertions($args[1], $result);
	}

    /**
     * @expectedException InvalidArgumentException
     */
	public function testLog10Zero()
	{
		$complex = new Complex(0);
		$result = $complex->log10();
	}

    /**
     * @dataProvider providerLog2
     */
	public function testLog2()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->log2();

        $this->complexNumberAssertions($args[1], $result);
	}

    /**
     * @expectedException InvalidArgumentException
     */
    public function testLog2Zero()
	{
		$complex = new Complex(0);
		$result = $complex->log2();
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
     * Results derived from Wolfram Alpha using
     *  N[Abs[<VALUE>], 18]
     */
    public function providerAbs()
    {
		$expectedResults = array(
			12,
			12.345,
            0.12345,
			14.0886318001429791,
			14.0886318001429791,
			6.79012230394269113,
			6.79012230394269113,
            0.690032689443043705,
            0.690032689443043705,
            9.8765,
            0.98765,
            10.7803660999986452,
            10.7803660999986452,
            1.07803660999986452,
            1.07803660999986452,
            3.14159265358979324,
            3.14159265358979324,
			1,
			1,
            0.123,
            0.123,
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Argument[<VALUE>], 18]
     */
    public function providerTheta()
    {
		$expectedResults = array(
			0.0,
			0.0,
            0.0,
			0.502796566091011651,
			-0.502796566091011651,
            1.55261450378897688,
            -1.55261450378897688,
            1.39092338385418624,
            -1.39092338385418624,
            M_PI, // 3.141592653589793
            M_PI, // 3.141592653589793
            2.72917955624616780,
            -2.72917955624616780,
            2.72917955624616780,
            -2.72917955624616780,
            M_PI / 2, // 1.57079632679489662
            -M_PI / 2, // -1.57079632679489662
            M_PI / 2, // 1.57079632679489662
            -M_PI / 2, // -1.57079632679489662
            M_PI / 2, // 1.57079632679489662
            -M_PI / 2, // -1.57079632679489662
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    public function providerRho()
    {
		$expectedResults = array(
			12,
			12.345,
            0.12345,
			14.08863180014298,
			14.08863180014298,
            6.790122303942691,
            6.790122303942691,
            0.6900326894430436,
            0.6900326894430436,
            9.8765,
            0.98765,
            10.78036609999864,
            10.78036609999864,
            1.078036609999865,
            1.078036609999865,
            3.14159265358979324,
            3.14159265358979324,
            1.0,
            1.0,
            0.123,
            0.123,
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Conjugate[<VALUE>], 18]
     */
    public function providerConjugate()
    {
		$expectedResults = array(
			12,
			12.345,
			0.12345,
            '12.345-6.789i',
            '12.345+6.789i',
            '0.12345-6.789i',
            '0.12345+6.789i',
            '0.12345-0.6789i',
            '0.12345+0.6789i',
			-9.8765,
            -0.98765,
			'-9.8765-4.321i',
			'-9.8765+4.321i',
			'-0.98765-0.4321i',
			'-0.98765+0.4321i',
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
     *  N[Cosine[<VALUE> Radians], 18]
     */
    public function providerCos()
    {
		$expectedResults = array(
			0.843853958732492105,
			0.975597424116876431,
            0.992389721111488176,
			'433.178045742218089+97.490377676007900i',
            '433.178045742218089-97.490377676007900i',
			'440.634045743687350-54.674160542549849i',
			'440.634045743687350+54.674160542549849i',
            '1.230008626496005725-0.090168869210320139i',
            '1.230008626496005725+0.090168869210320139i',
            -0.899696739907973162,
            0.550653004753812240,
            '-33.8632992264903040-16.4240194053061343i',
            '-33.8632992264903040+16.4240194053061343i',
            '0.602864164806169264+0.372017973792045322i',
            '0.602864164806169264-0.372017973792045322i',
            11.5919532755215206,
            11.5919532755215206,
			1.54308063481524378,
			1.54308063481524378,
            1.00757404175415510,
            1.00757404175415510,
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[CosH[<VALUE> Radians], 18]
     */
    public function providerCosH()
    {
		$expectedResults = array(
			81377.3957125740666,
            114904.062432798705,
            1.00762963344353832,
            '100515.7791343315882+55673.3482767474063i',
            '100515.7791343315882-55673.3482767474063i',
            '0.881454280553858263+0.059966070794460000i',
            '0.881454280553858263-0.059966070794460000i',
            '0.784201788942208582+0.077715908123191951i',
            '0.784201788942208582-0.077715908123191951i',
            9733.73360047018858,
            1.52868420987951655,
            '-3713.15391515609948+8997.66952898386423i',
            '-3713.15391515609948-8997.66952898386423i',
            '1.38818027193114323-0.48420588419596441i',
            '1.38818027193114323+0.48420588419596441i',
            -1.0,
            -1.0,
            0.540302305868139717,
            0.540302305868139717,
            0.992445032135193570,
            0.992445032135193570,
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
     *  N[Sine[<VALUE> Radians], 18]
     */
    public function providerSin()
    {
		$expectedResults = array(
            -0.536572918000434972,
            -0.219566996737933121,
            0.123136677851332009,
            '-97.490624929152629+433.176947127514213i',
            '-97.490624929152629-433.176947127514213i',
            '54.674299206061591+440.632928219273450i',
            '54.674299206061591-440.632928219273450i',
            '0.152620661795611862+0.726693788804372014i',
            '0.152620661795611862-0.726693788804372014i',
            0.436515493652819720,
            -0.834734250139287165,
            '16.42981920783279-33.85134532450693i',
            '16.42981920783279+33.85134532450693i',
            '-0.913881087001989+0.245410817942156i',
            '-0.913881087001989-0.245410817942156i',
            '11.5487393572577484i',
            '-11.5487393572577484i',
            '1.17520119364380146i',
            '-1.17520119364380146i',
            '0.123310379193334229i',
            '-0.1233103791933342i'

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
     *  N[SinH[<VALUE> Radians], 18]
     */
    public function providerSinH()
    {
		$expectedResults = array(
			81377.3957064298542,
            114904.062428447249,
            0.123763800012602234,
            '100515.7791305250211+55673.3482788557751i',
            '100515.7791305250211-55673.3482788557751i',
            '0.108266100636502154+0.488216990166093592i',
            '0.108266100636502154-0.488216990166093592i',
            '0.096320900214579535+0.632728245310258886i',
            '0.096320900214579535-0.632728245310258886i',
            -9733.73354910243784,
            -1.15623328681324593,
            '3713.15389556070345-8997.66957646719047i',
            '3713.15389556070345+8997.66957646719047i',
            '-1.049961939903045305+0.640180401259003748i',
            '-1.049961939903045305-0.640180401259003748i',
            '-1.53735661672049712E-18i',
            '-1.53735661672049712E-18i',
            '0.841470984807896507i',
            '-0.841470984807896507i',
            '0.122690090024315336i',
            '-0.123310379193334229i',
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Sec[<VALUE> Radians], 18]
     */
    public function providerSec()
    {
		$expectedResults = array(
			1.18503917609398493,
            1.02501295645097987,
            1.00766863937283452,
            '0.00219722715877619811-0.00049450452915277163i',
            '0.00219722715877619811+0.00049450452915277163i',
            '0.00223504616546252215+0.00027732598978879297i',
            '0.00223504616546252215-0.00027732598978879297i',
            '0.808656714283989823+0.059280609855590377i',
            '0.808656714283989823-0.059280609855590377i',
            -1.11148563248354830,
            1.81602568471788017,
            '-0.0239067997283027954+0.0115950232737292425i',
            '-0.0239067997283027954-0.0115950232737292425i',
            '1.201301356245620536-0.741304132097185254i',
            '1.201301356245620536+0.741304132097185254i',
            0.0862667383340544146,
            0.0862667383340544146,
            0.648054273663885400,
            0.648054273663885400,
            0.992482893127170164,
            0.992482893127170164,
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[SecH[<VALUE> Radians], 18]
     */
    public function providerSecH()
    {
		$expectedResults = array(
			0.0000122884247061925150,
            8.70291248914586449E-6,
            0.992428137094912224,
            '7.61313404486084631E-6-4.21673757898906154E-6i',
            '7.61313404486084631E-6+4.21673757898906154E-6i',
            '1.129262343994501309-0.076824660290879901i',
            '1.129262343994501309+0.076824660290879901i',
            '1.262779988289303536-0.125143929704716813i',
            '1.262779988289303536+0.125143929704716813i',
            0.000102735501200864480,
            0.654157342332210739,
            '-0.0000391907923113348644-0.0000949666525691565824i',
            '-0.0000391907923113348644+0.0000949666525691565824i',
            '0.642230116463789304+0.224013845814869186i',
            '0.642230116463789304-0.224013845814869186i',
            -1.0,
            -1.0,
            1.85081571768092562,
            1.85081571768092562,
            1.00761247990586674,
            1.00761247990586674,
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

    /*
     * Results derived from Wolfram Alpha using
     *  N[CoSec[<VALUE> Radians], 18]
     */
    public function providerCsc()
    {
		$expectedResults = array(
			-1.86367959778243849,
            -4.55441853674194147,
            8.12105716549654890,
            '-0.00049450804976921878-0.00219723165673293340i',
            '-0.00049450804976921878+0.00219723165673293340i',
            '0.00027732805718126026-0.00223505149014498655i',
            '0.00027732805718126026+0.00223505149014498655i',
            '0.276799143639273659-1.317961906746316859i',
            '0.276799143639273659+1.317961906746316859i',
            2.29086942970080391,
            -1.19798606542517684,
            '0.01160418811259422+0.02390880715368388i',
            '0.01160418811259422-0.02390880715368388i',
            '-1.020634209071783-0.274077973196426i',
            '-1.020634209071783+0.274077973196426i',
            '-0.0865895375300469417i',
            '0.086589537530046942i',
            '-0.850918128239321545i',
            '0.85091812823932155i',
            '-8.10961742670609559i',
            '8.1096174267061i',
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Sqrt[<VALUE>], 18]
     */
    public function providerSqrt()
    {
		$expectedResults = array(
			3.46410161513775459,
			3.51354521815217286,
            0.351354521815217286,
            '3.63549390043106654+0.93371082250956562i',
            '3.63549390043106654-0.93371082250956562i',
            '1.85924343537131941+1.82574263026620090i',
            '1.85924343537131941-1.82574263026620090i',
            '0.637762765236041240+0.532251204528014058i',
            '0.637762765236041240-0.532251204528014058i',
            '3.14268993061676385i',
            '0.993805816042550638i',
            '0.67225965965490047+3.21378795971347845i',
            '0.67225965965490047-3.21378795971347845i',
            '0.212587170355908969+1.016288986952004839i',
            '0.212587170355908969-1.016288986952004839i',
            '1.25331413731550025+1.25331413731550025i',
            '1.25331413731550025-1.25331413731550025i',
            '0.707106781186547524+0.707106781186547524i',
            '0.707106781186547524-0.707106781186547524i',
            '0.247991935352744888+0.247991935352744888i',
            '0.247991935352744888-0.247991935352744888i',
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Exp[<VALUE>], 18]
     */
    public function providerExp()
    {
		$expectedResults = array(
			162754.791419003921,
			229808.124861245955,
            1.13139343345614055,
            '201031.558264856609+111346.696555603181i',
            '201031.558264856609-111346.696555603181i',
            '0.989720381190360417+0.548183060960553592i',
            '0.989720381190360417-0.548183060960553592i',
            '0.880522689156788117+0.710444153433450838i',
            '0.880522689156788117-0.710444153433450838i',
            0.0000513677507359735403,
            0.372450923066270627,
            '-0.0000195953960306484277-0.0000474833262322171154i',
            '-0.0000195953960306484277+0.0000474833262322171154i',
            '0.338218332028097927+0.155974517063039339i',
            '0.338218332028097927-0.155974517063039339i',
            '-1.0',
            '-1.0',
            '0.540302305868139717+0.841470984807896507i',
            '0.540302305868139717-0.841470984807896507i',
            '0.992445032135193570+0.122690090024315336i',
            '0.992445032135193570-0.122690090024315336i',
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Ln[<VALUE>], 18]
     */
    public function providerLn()
    {
		$expectedResults = array(
			2.48490664978800031,
			2.51325112279714283,
            -2.09191906319094854,
            '2.64536821687649521+0.50279656609101165i',
            '2.64536821687649521-0.50279656609101165i',
            '1.91546895377107794+1.55261450378897688i',
            '1.91546895377107794-1.55261450378897688i',
            '-0.37101630650862827+1.39092338385418624i',
            '-0.37101630650862827-1.39092338385418624i',
            '2.29015819798591819+3.14159265358979324i',
            '-0.0124268950081274937+3.14159265358979324i',
            '2.37772652594302344+2.72917955624616780i',
            '2.37772652594302344-2.72917955624616780i',
            '0.07514143294897775+2.72917955624616780i',
            '0.07514143294897775-2.72917955624616780i',
            '1.14472988584940017+1.57079632679489662i',
            '1.14472988584940017-1.57079632679489662i',
            '1.57079632679489662i',
            '-1.57079632679489662i',
            '-2.09557092360971956+1.57079632679489662i',
            '-2.09557092360971956-1.57079632679489662i',
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Log10[<VALUE>], 18]
     */
    public function providerLog10()
    {
		$expectedResults = array(
			1.07918124604762483,
			1.09149109426795108,
			-0.908508905732048918,
            '1.148868819191706605+0.218361774173230021i',
            '1.148868819191706605-0.218361774173230021i',
            '0.831877596879774119+0.674291911518508134i',
            '0.831877596879774119-0.674291911518508134i',
            '-0.161130334612822794+0.604070350358071680i',
            '-0.161130334612822794-0.604070350358071680i',
            '0.99460306807077916+1.36437635384184135i',
            '-0.005396931929220836+1.364376353841841347i',
            '1.03263350969204423+1.18526762140087618i',
            '1.03263350969204423-1.18526762140087618i',
            '0.032633509692044229+1.185267621400876176i',
            '0.032633509692044229-1.185267621400876176i',
            '0.497149872694133855+0.682188176920920674i',
            '0.497149872694133855-0.682188176920920674i',
            '0.682188176920920674i',
            '-0.682188176920920674i',
            '-0.910094888560602068+0.682188176920920674i',
            '-0.910094888560602068-0.682188176920920674i',
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Log2[<VALUE>], 18]
     */
    public function providerLog2()
    {
		$expectedResults = array(
			3.58496250072115618,
			3.62585493136805716,
            -3.01800125840666753,
            '3.81645960781299948+0.72538211247550245i',
            '3.81645960781299948-0.72538211247550245i',
            '2.76343756058230524+2.23994924502863563i',
            '2.76343756058230524-2.23994924502863563i',
            '-0.53526338548893765+2.00667826814293056i',
            '-0.53526338548893765-2.00667826814293056i',
            '3.30399987508548900+4.53236014182719381i',
            '-0.01792821980187335+4.53236014182719381i',
            '3.43033426756814311+3.93737381149188807i',
            '3.43033426756814311-3.93737381149188807i',
            '0.10840617268078076+3.93737381149188807i',
            '0.10840617268078076-3.93737381149188807i',
            '1.65149612947231880+2.26618007091359690i',
            '1.65149612947231880-2.26618007091359690i',
            '2.26618007091359690i',
            '-2.26618007091359690i',
            '-3.02326977932284717+2.26618007091359690i',
            '-3.02326977932284717-2.26618007091359690i',
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

}
