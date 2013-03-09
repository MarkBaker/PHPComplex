<?php

include 'Complex.php';

class ComplexTest extends PHPUnit_Framework_TestCase
{

    public function testInstantiate()
    {
        $complexObject = new Complex();
        //    Must return an object...
        $this->assertTrue(is_object($complexObject));
        //    ... of the correct type
        $this->assertTrue(is_a($complexObject, 'Complex'));

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
		$result = $complex->format();

        $this->assertEquals($args[2], $result);
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
		$result = $complex->format();

        $this->assertEquals($args[2], $result);
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
		$result = $complex->format();

        $this->assertEquals($args[2], $result);
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
		$result = $complex->format();

        $this->assertEquals($args[2], $result);
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
		$result = $complex->format();

        $this->assertEquals($args[2], $result);
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
			'-0.12746100416566-0.075743632655042i',
			'-0.12499924062475-0.07988627596304i',
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
			'-5.7980554621323+3.4454913164385i',
			'-5.6800726089814+3.6301008363193i',
			'-3.2872812413246E-5-0.0010114319212209i',
			'3.2872812413246E-5+0.0010114319212209i',
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

}
