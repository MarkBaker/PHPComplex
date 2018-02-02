<?php

namespace Complex;

use Complex\Complex as Complex;

class ComplexTest extends \PHPUnit\Framework\TestCase
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
            $this->assertEquals($expected->getReal(), $result->getReal(), 'Real Component', $this->getAssertionPrecision($expected->getReal()));
            $this->assertEquals($expected->getImaginary(), $result->getImaginary(), 'Imaginary Component', $this->getAssertionPrecision($expected->getImaginary()));
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

        $complexObject = new Complex(0.0);
        $format = $complexObject->format();
        $this->assertEquals('0.0', $format);
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
     * @expectedException Exception
     */
    public function testDivideByZero()
    {
        $complex = new Complex('2.5-i');
        $complex->divideBy(0.0);
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
     * @expectedException Exception
     */
    public function testDivideIntoByZero()
    {
        $complex = new Complex(0.0);
        $complex->divideInto(
            new Complex('2.5-i')
        );
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
     * @expectedException Exception
     */
    public function testValidateComplexArgument()
    {
        $nonComplex = new \stdClass();
        Complex::validateComplexArgument($nonComplex);
    }


    private $_oneComplexValueDataSets = array(
        array(12,       NULL,       NULL),
        array(12.345,   NULL,       NULL),
        array(0.12345,  NULL,       NULL),
        array(12.345,   6.789,      NULL),
        array(12.345,   -6.789,     NULL),
        array(0.12345,  6.789,      NULL),
        array(0.12345,  -6.789,     NULL),
        array(0.12345,  0.6789,     NULL),
        array(0.12345,  -0.6789,    NULL),
        array(-9.8765,  NULL,       NULL),
        array(-0.98765, NULL,       NULL),
        array(-9.8765,  +4.321,     NULL),
        array(-9.8765,  -4.321,     NULL),
        array(-0.98765, 0.4321,     NULL),
        array(-0.98765, -0.4321,    NULL),
        array(0,        M_PI,       NULL),
        array(0,        -3.14159265358979324,   NULL),  // Shame we can't yet have dynamic expressions in property definitions
        array(0,        1,          NULL),
        array(0,        -1,         NULL),
        array(0,        0.123,      NULL),
        array(0,        -0.123,     NULL),
    );

    private function _formatOneArgumentTestResultArray($expectedResults)
    {
        $testValues = array();
        foreach ($this->_oneComplexValueDataSets as $test => $dataSet) {
            $testValues[$test][] = $dataSet;
            $testValues[$test][] = $expectedResults[$test];
        }

        return $testValues;
    }

    private $_twoComplexValueDataSets = array(
        array(123,      NULL,   NULL,   456,        NULL,   NULL),
        array(123.456,  NULL,   NULL,   789.012,    NULL,   NULL),
        array(123.456,  78.90,  NULL,   -987.654,   -32.1,  NULL),
        array(123.456,  78.90,  NULL,   -987.654,   NULL,   NULL),
        array(-987.654, -32.1,  NULL,   0,          1,      NULL),
        array(-987.654, -32.1,  NULL,   0,          -1,     NULL),
    );

    private function _formatTwoArgumentTestResultArray($expectedResults)
    {
        $testValues = array();
        foreach ($this->_twoComplexValueDataSets as $test => $dataSet) {
            $testValues[$test][] = array_slice($dataSet, 0, 3);
            $testValues[$test][] = array_slice($dataSet, 3, 3);
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
}
