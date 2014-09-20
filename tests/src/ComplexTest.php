<?php

namespace MarkBaker\PHPComplex;
use MarkBaker\PHPComplex\Complex as Complex;

include 'Complex.php';

class ComplexTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $this->_precision = ini_set('precision', 16);
    }

    protected function tearDown()
    {
        ini_set('precision', $this->_precision);
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

    public function testInstantiateSimplistic()
    {
        $complexObject = new Complex('-i');

        $defaultComplexReal = $complexObject->getReal();
        $this->assertEquals(0, $defaultComplexReal);

        $defaultComplexImaginary = $complexObject->getImaginary();
        $this->assertEquals(-1, $defaultComplexImaginary);

        $defaultComplexSuffix = $complexObject->getSuffix();
        $this->assertEquals('i', $defaultComplexSuffix);
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
     * @dataProvider providerArgument
     */
	public function testArgument()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->argument();

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

        if (is_numeric($args[1])) {
            $this->assertEquals($args[1], (string) $result);
        } else {
            $expected = new Complex($args[1]);
            $this->assertEquals($expected->getReal(), $result->getReal());
            $this->assertEquals($expected->getImaginary(), $result->getImaginary());
        }
	}

    /**
     * @dataProvider providerCos
     */
	public function testCos()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->cos();

        if (is_numeric($args[1])) {
            $this->assertEquals($args[1], (string) $result);
        } else {
            $expected = new Complex($args[1]);
            $this->assertEquals($expected->getReal(), $result->getReal());
            $this->assertEquals($expected->getImaginary(), $result->getImaginary());
        }
	}

    /**
     * @dataProvider providerSin
     */
	public function testSin()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->sin();

        if (is_numeric($args[1])) {
            $this->assertEquals($args[1], (string) $result);
        } else {
            $expected = new Complex($args[1]);
            $this->assertEquals($expected->getReal(), $result->getReal());
            $this->assertEquals($expected->getImaginary(), $result->getImaginary());
        }
	}

    /**
     * @dataProvider providerSqrt
     */
	public function testSqrt()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->sqrt();

        if (is_numeric($args[1])) {
            $this->assertEquals($args[1], (string) $result);
        } else {
            $expected = new Complex($args[1]);
            $this->assertEquals($expected->getReal(), $result->getReal());
            $this->assertEquals($expected->getImaginary(), $result->getImaginary());
        }
	}

    /**
     * @dataProvider providerLn
     */
	public function testLn()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->ln();

        if (is_numeric($args[1])) {
            $this->assertEquals($args[1], (string) $result);
        } else {
            $expected = new Complex($args[1]);
            $this->assertEquals($expected->getReal(), $result->getReal());
            $this->assertEquals($expected->getImaginary(), $result->getImaginary());
        }
	}

	public function testLnZero()
	{
		$complex = new Complex(0);
		$result = (string) $complex->ln();

        $this->assertEquals('0', $result);
	}

    /**
     * @dataProvider providerLog10
     */
	public function testLog10()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->log10();

        if (is_numeric($args[1])) {
            $this->assertEquals($args[1], (string) $result);
        } else {
            $expected = new Complex($args[1]);
            $this->assertEquals($expected->getReal(), $result->getReal());
            $this->assertEquals($expected->getImaginary(), $result->getImaginary());
        }
	}

	public function testLog10Zero()
	{
		$complex = new Complex(0);
		$result = (string) $complex->log10();

        $this->assertEquals('0', $result);
	}

    /**
     * @dataProvider providerLog2
     */
	public function testLog2()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->log2();

        if (is_numeric($args[1])) {
            $this->assertEquals($args[1], (string) $result);
        } else {
            $expected = new Complex($args[1]);
            $this->assertEquals($expected->getReal(), $result->getReal());
            $this->assertEquals($expected->getImaginary(), $result->getImaginary());
        }
	}

	public function testLog2Zero()
	{
		$complex = new Complex(0);
		$result = (string) $complex->log2();

        $this->assertEquals('0', $result);
	}


    private $_oneComplexValueDataSets = array(
		array(123,		NULL,	NULL),
		array(123.456,	NULL,	NULL),
		array(123.456,	78.90,	NULL),
		array(-987.654,	NULL,	NULL),
		array(-987.654,	-32.1,	NULL),
		array(123.456,	-78.90,	NULL),
		array(0,		1,		NULL),
		array(0,		-1,		NULL),
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

    public function providerAbs()
    {
		$expectedResults = array(
			123,
			123.456,
			146.51482497004,
			987.654,
			988.17550754712,
			146.51482497004,
			1,
			1
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    public function providerArgument()
    {
		$expectedResults = array(
			0,
			0,
			0.56867025520691,
			M_PI,
			-3.109102829819,
			-0.56867025520691,
			1.5707963267949,
			-1.5707963267949
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    public function providerConjugate()
    {
		$expectedResults = array(
			123,
			123.456,
			'123.456-78.9i',
			-987.654,
			'-987.654+32.1i',
			'123.456+78.9i',
			'-i',
			'i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    public function providerCos()
    {
		$expectedResults = array(
			-0.887968906691855,
			-0.594713971092157,
			'-5.484193473795067E+33+7.413560609599075E+33i',
			0.36803011855732,
			'16058546551240.22-40571297167732.33i',
			'-5.484193473795067E+33-7.413560609599075E+33i',
			1.54308063481524,
			1.54308063481524
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    public function providerSin()
    {
		$expectedResults = array(
			-0.459903490689591,
			-0.803937368572824,
			'-7.413560609599075E+33-5.484193473795067E+33i',
			-0.929813869457046,
			'-40571297167732.33-16058546551240.22i',
			'-7.413560609599075E+33+5.484193473795067E+33i',
			'1.175201193643801i',
			'-1.175201193643801i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    public function providerSqrt()
    {
		$expectedResults = array(
			11.0905365064094,
			11.1110755554987,
			'11.618322274968+3.395498856577265i',
			'1.9251347547791E-15+31.42696294585272i',
			'0.5106405522066606-31.43111123987757i',
			'11.618322274968-3.395498856577265i',
			'0.7071067811865476+0.7071067811865475i',
			'0.7071067811865476-0.7071067811865475i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    public function providerLn()
    {
		$expectedResults = array(
			4.81218435537242,
			4.81588481728326,
			'4.987126617672031+0.5686702552069114i',
			'6.895332433983527+3.141592653589793i',
			'6.895860321189619-3.109102829818983i',
			'4.987126617672031-0.5686702552069114i',
			'1.570796326794897i',
			'-1.570796326794897i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    public function providerLog10()
    {
		$expectedResults = array(
			2.0899051114394,
			2.09151220162777,
			'2.165881570607791+0.2469703538588756i',
			'2.994604826967564+1.364376353841841i',
			'2.994834085468237-1.35026620266017i',
			'2.165881570607791-0.2469703538588756i',
			'0.6821881769209206i',
			'-0.6821881769209206i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

    public function providerLog2()
    {
		$expectedResults = array(
			6.94251450533924,
			6.94785314338702,
			'7.194902839600788+0.8204177570880723i',
			'9.947861907788861+4.532360141827193i',
			'9.948623488043237-4.48548723419369i',
			'7.194902839600788-0.8204177570880723i',
			'2.266180070913597i',
			'-2.266180070913597i'
		);

		return $this->_formatOneArgumentTestResultArray($expectedResults);
	}

}
