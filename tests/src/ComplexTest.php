<?php

namespace MarkBaker\PHPComplex;
use MarkBaker\PHPComplex\Complex as Complex;

include 'Complex.php';

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
		array(123,		NULL,	    NULL),
		array(123.456,	NULL,	    NULL),
		array(0.123,	NULL,	    NULL),
		array(123.456,	78.90,	    NULL),
		array(123.456,	-78.90,	    NULL),
		array(0.123,	45.67,	    NULL),
		array(0.123,	-45.67,	    NULL),
		array(0.123,	0.4567, 	NULL),
		array(0.123,	-0.4567,	NULL),
		array(-987.654,	NULL,	    NULL),
		array(-0.9876,	NULL,	    NULL),
		array(-987.654,	+32.1,	    NULL),
		array(-987.654,	-32.1,	    NULL),
		array(-0.98765,	0.4321,	    NULL),
		array(-0.98765,	-0.4321,	NULL),
		array(0,		1,		    NULL),
		array(0,		-1,		    NULL),
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
     *  N[Abs[<VALUE>], 16]
     */
    public function providerAbs()
    {
		$expectedResults = array(
			123,
			123.456,
            0.123,
			146.5148249700350,
			146.5148249700350,
			45.67016563359498,
			45.67016563359498,
            0.4729734559148114,
            0.4729734559148114,
            987.654,
            0.9876,
            988.1755075471158,
            988.1755075471158,
            1.078036609999865,
            1.078036609999865,
			1,
			1
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Argument[<VALUE>], 16]
     */
    public function providerTheta()
    {
		$expectedResults = array(
			0.0,
			0.0,
            0.0,
			0.5686702552069113,
			-0.5686702552069113,
            1.568103099236162,
            -1.568103099236162,
            1.307715220341907,
            -1.307715220341907,
            M_PI, // 3.141592653589793
            M_PI, // 3.141592653589793
            3.109102829818983,
            -3.109102829818983,
            2.729179556246168,
            -2.729179556246168,
            1.570796326794897,
            -1.570796326794897
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    public function providerRho()
    {
		$expectedResults = array(
			123,
			123.456,
            0.123,
			146.514824970035,
			146.514824970035,
            45.67016563359498,
            45.67016563359498,
            0.4729734559148113,
            0.4729734559148113,
            987.654,
            0.9876,
            988.1755075471159,
            988.1755075471159,
            1.078036609999865,
            1.078036609999865,
            1.0,
            1.0
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Conjugate[<VALUE>], 16]
     */
    public function providerConjugate()
    {
		$expectedResults = array(
			123,
			123.456,
			0.123,
            '123.456-78.9i',
            '123.456+78.90i',
            '0.123-45.67i',
            '0.123+45.67i',
            '0.123-0.4567i',
            '0.123+0.4567i',
			-987.654,
            -0.9876,
			'-987.654-32.1i',
			'-987.654+32.1i',
			'-0.98765-0.4321i',
			'-0.98765+0.4321i',
			'-i',
			'i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     */
    public function providerNegative()
    {
		$expectedResults = array(
			-123,
			-123.456,
			-0.123,
            '-123.456-78.9i',
            '-123.456+78.90i',
            '-0.123-45.67i',
            '-0.123+45.67i',
            '-0.123-0.4567i',
            '-0.123+0.4567i',
			987.654,
            0.9876,
			'987.654-32.1i',
			'987.654+32.1i',
			'0.98765-0.4321i',
			'0.98765+0.4321i',
			'-i',
			'i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Cosine[<VALUE> Radians], 16]
     */
    public function providerCos()
    {
		$expectedResults = array(
			-0.8879689066918554,
			-0.5947139710921599,
            0.9924450321351936,
			'-5.484193473795059E+33+7.413560609599015E+33i',
            '-5.484193473795059E+33-7.413560609599015E+33i',
			'3.387703984974821E+19-4.18801740584131E+18i',
			'3.387703984974821E+19+4.18801740584131E+18i',
            '1.0977560934508640-0.0580008096991907i',
            '1.0977560934508640+0.0580008096991907i',
            0.3680301185573163,
            0.5506947407779856,
            '1.605854655124005E+13+4.057129716773233E+13i',
            '1.605854655124005E+13-4.057129716773233E+13i',
            '0.6028641648061693+0.3720179737920453i',
            '0.6028641648061693-0.3720179737920453i',
			1.543080634815244,
			1.543080634815244
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[CosH[<VALUE> Radians], 16]
     */
    public function providerCosH()
    {
		$expectedResults = array(
			1.309758659374531E+53,
            2.066472176389047E+53,
            1.007574041754155,
            '-1.933871015264479E+53-7.28320089047404E+52i',
            '-1.933871015264479E+53+7.28320089047404E+52i',
            '-0.1175238479821412+0.1224686886673032i',
            '-0.1175238479821412-0.1224686886673032i',
            '0.9043104428632838+0.0543784865045672i',
            '0.9043104428632838-0.0543784865045672i',
            '4.282054929081878E+428',
            1.528626400126007,
            '3.318613590036468E+428-2.706066934815115E+428i',
            '3.318613590036468E+428+2.706066934815115E+428i',
            '1.388180271931143-0.484205884195964i',
            '1.388180271931143+0.484205884195964i',
            0.5403023058681397,
            0.5403023058681397
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[ArcCos[<VALUE>], 16]
     */
    public function providerACos()
    {
		$expectedResults = array(
			'5.505315010967267i',
			'5.509015594729667i',
            '1.447484051603025',
			'0.568680824338368-5.680268906931791i',
			'0.568680824338368+5.680268906931791i',
			'1.568103744622331-4.514712271372172i',
			'1.568103744622331+4.514712271372172i',
			'1.458800171761187-0.444769501075402i',
			'1.458800171761187+0.444769501075402i',
            '3.141592653589793-7.588479358254145i',
            2.983949310915565,
            '3.109102813194665-7.589007246270989i',
            '3.109102813194665+7.589007246270989i',
            '2.499592209421656-0.670281385591987i',
            '2.499592209421656+0.670281385591987i',
            '1.570796326794897-0.881373587019543i',
            '1.570796326794897+0.881373587019543i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Sine[<VALUE> Radians], 16]
     */
    public function providerSin()
    {
		$expectedResults = array(
            -0.4599034906895913,
            -0.8039373685728221,
            0.1226900900243153,
            '-7.413560609599015E+33-5.484193473795059E+33i',
            '-7.413560609599015E+33+5.484193473795059E+33i',
            '4.18801740584131E+18+3.387703984974821E+19i',
            '4.18801740584131E+18-3.387703984974821E+19i',
            '0.1357090716051670+0.4691708632243445i',
            '0.1357090716051670-0.4691708632243445i',
            -0.9298138694570477,
            -0.8347067164456431,
            '-4.057129716773233E+13+1.605854655124005E+13i',
            '-4.057129716773233E+13-1.605854655124005E+13i',
            '-0.9138810870019890+0.2454108179421560i',
            '-0.9138810870019890-0.2454108179421560i',
            '1.175201193643801i',
            '-1.175201193643801i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[ArcSin[<VALUE>], 16]
     */
    public function providerASin()
    {
		$expectedResults = array(
			'1.570796326794897-5.505315010967267i',
			'1.570796326794897-5.509015594729667i',
            0.1233122751918720,
            '1.002115502456529+5.680268906931791i',
            '1.002115502456529-5.680268906931791i',
            '0.002692582172566+4.514712271372172i',
            '0.002692582172566-4.514712271372172i',
            '0.1119961550337093+0.4447695010754023i',
            '0.1119961550337093-0.4447695010754023i',
            '-1.570796326794897+7.588479358254145i',
            -1.413152984120669,
            '-1.538306486399768+7.589007246270989i',
            '-1.538306486399768-7.589007246270989i',
            '-0.9287958826267596+0.6702813855919873i',
            '-0.9287958826267596-0.6702813855919873i',
            '0.8813735870195430i',
            '-0.8813735870195430i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[SinH[<VALUE> Radians], 16]
     */
    public function providerSinH()
    {
		$expectedResults = array(
			1.309758659374531E+53,
            2.066472176389047E+53,
            0.1233103791933342,
            '-1.933871015264479E+53-7.28320089047404E+52i',
            '-1.933871015264479E+53+7.28320089047404E+52i',
            '-0.0143829730207297+1.0006965547918482i',
            '-0.0143829730207297-1.0006965547918482i',
            '0.1106726245386657+0.4443287887873297i',
            '0.1106726245386657-0.4443287887873297i',
            -4.282054929081878E+428,
            -1.156156854048012,
            '-3.318613590036468E+428+2.706066934815115E+428i',
            '-3.318613590036468E+428-2.706066934815115E+428i',
            '-1.0499619399030453+0.6401804012590037i',
            '-1.0499619399030453-0.6401804012590037i',
            '0.8414709848078965i',
            '-0.8414709848078965i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Sec[<VALUE> Radians], 16]
     */
    public function providerSec()
    {
		$expectedResults = array(
			-1.126165558798132,
            -1.681480591692767,
            1.007612479905867,
            '-6.449165389627598E-35-8.718014549593755E-35i',
            '-6.449165389627598E-35+8.718014549593755E-35i',
            '2.907417962662243E-20+3.59426829725669E-21i',
            '2.907417962662243E-20-3.59426829725669E-21i',
            '0.9084132229054091+0.0479967296782065i',
            '0.9084132229054091-0.0479967296782065i',
            2.717168920630777,
            1.815888051858395,
            '8.43452224851900E-15-2.130949445023649E-14i',
            '8.43452224851900E-15+2.130949445023649E-14i',
            '1.2013013562456205-0.7413041320971853i',
            '1.2013013562456205+0.7413041320971853i',
            0.6480542736638854,
            0.6480542736638854
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[CoSec[<VALUE> Radians], 16]
     */
    public function providerCsc()
    {
		$expectedResults = array(
			-2.174369232337363,
            -1.243877992355593,
            8.150617542148799,
            '-8.718014549593755E-35+6.449165389627598E-35i',
            '-8.718014549593755E-35-6.449165389627598E-35i',
            '3.59426829725669E-21-2.907417962662243E-20i',
            '3.59426829725669E-21+2.907417962662243E-20i',
            '0.568919538178610-1.966857982854930i',
            '0.568919538178610+1.966857982854930i',
            -1.075484064981668,
            -1.198025582276623,
            '-2.130949445023643E-14-8.43452224851907E-15i',
            '-2.130949445023643E-14+8.43452224851907E-15i',
            '-1.020634209071783-0.274077973196426i',
            '-1.020634209071783+0.274077973196426i',
            '-0.8509181282393215i',
            '0.850918128239322i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Sqrt[<VALUE>], 16]
     */
    public function providerSqrt()
    {
		$expectedResults = array(
			11.09053650640942,
			11.11107555549867,
            0.3507135583350036,
            '11.618322274967996+3.395498856577265i',
            '11.618322274967996-3.395498856577265i',
            '4.785037389278948+4.772167517679727i',
            '4.785037389278948-4.772167517679727i',
            '0.5458816061724426+0.4183141498412475i',
            '0.5458816061724426-0.4183141498412475i',
            '31.42696294585272i',
            '0.9937806599043876i',
            '0.51064055220666+31.43111123987757i',
            '0.51064055220666-31.43111123987757i',
            '0.2125871703559090+1.0162889869520048i',
            '0.2125871703559090-1.0162889869520048i',
            '0.7071067811865475+0.7071067811865475i',
            '0.7071067811865475-0.7071067811865475i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Exp[<VALUE>], 16]
     */
    public function providerExp()
    {
		$expectedResults = array(
			2.619517318749063E+53,
			4.132944352778093E+53,
            1.130884420947489,
            '-3.867742030528957E+53-1.456640178094807E+53i',
            '-3.867742030528957E+53+1.456640178094807E+53i',
            '-0.1319068210028709+1.1231652434591514i',
            '-0.1319068210028709-1.1231652434591514i',
            '1.0149830674019495+0.4987072752918969i',
            '1.0149830674019495-0.4987072752918969i',
            1.167663676157479E-429,
            0.3724695460779954,
            '9.049450809167929E-430+7.379111471865009E-430i',
            '9.049450809167929E-430-7.379111471865009E-430i',
            '0.3382183320280979+0.1559745170630393i',
            '0.3382183320280979-0.1559745170630393i',
            '0.5403023058681397+0.8414709848078965i',
            '0.5403023058681397-0.8414709848078965i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Ln[<VALUE>], 16]
     */
    public function providerLn()
    {
		$expectedResults = array(
			4.812184355372417,
			4.815884817283264,
            -2.095570923609720,
            '4.987126617672031+0.568670255206911i',
            '4.987126617672031-0.568670255206911i',
            '3.821445253938634+1.568103099236162i',
            '3.821445253938634-1.568103099236162i',
            '-0.748716010638248+1.307715220341907i',
            '-0.748716010638248-1.307715220341907i',
            '6.895332433983527+3.141592653589793i',
            '-0.01247752151111261+3.141592653589793i',
            '6.895860321189619+3.109102829818983i',
            '6.895860321189619-3.109102829818983i',
            '0.075141432948978+2.729179556246168i',
            '0.075141432948978-2.729179556246168i',
            '1.570796326794897i',
            '-1.570796326794897i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Log10[<VALUE>], 16]
     */
    public function providerLog10()
    {
		$expectedResults = array(
			2.089905111439398,
			2.091512201627772,
			-0.9100948885606021,
            '2.165881570607791+0.246970353858876i',
            '2.165881570607791-0.246970353858876i',
            '1.659632586680919+0.681018523053653i',
            '1.659632586680919-0.681018523053653i',
            '-0.3251632319328073+0.5679335040953854i',
            '-0.3251632319328073-0.5679335040953854i',
            '2.994604826967564+1.364376353841841i',
            '-0.0054189187401053+1.3643763538418413i',
            '2.994834085468237+1.350266202660170i',
            '2.994834085468237-1.350266202660170i',
            '0.0326335096920442+1.1852676214008762i',
            '0.0326335096920442-1.1852676214008762i',
            '0.6821881769209207i',
            '-0.6821881769209207i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Log2[<VALUE>], 16]
     */
    public function providerLog2()
    {
		$expectedResults = array(
			6.942514505339240,
			6.947853143387016,
            -3.023269779322847,
            '7.194902839600788+0.820417757088072i',
            '7.194902839600788-0.820417757088072i',
            '5.513180116885932+2.262294564870625i',
            '5.513180116885932-2.262294564870625i',
            '-1.080168875581968+1.886634263282288i',
            '-1.080168875581968-1.886634263282288i',
            '9.947861907788860+4.532360141827194i',
            '-0.018001258406668+4.532360141827194i',
            '9.948623488043237+4.485487234193690i',
            '9.948623488043237-4.485487234193690i',
            '0.108406172680781+3.937373811491888i',
            '0.108406172680781-3.937373811491888i',
            '2.266180070913597i',
            '-2.266180070913597i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

}
