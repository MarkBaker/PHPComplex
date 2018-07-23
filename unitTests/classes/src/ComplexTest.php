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
        return \pow(10, floor(\log10($value)) - $this->significantDigits + 1);
    }

    public function complexNumberAssertions($expected, $result)
    {
        if (is_numeric($expected)) {
            $this->assertEquals($expected, $result->getReal(), 'Numeric Assertion', $this->getAssertionPrecision($expected));
        } else {
            $expected = new Complex($expected);
            $this->assertEquals(
                $expected->getReal(),
                $result->getReal(),
                'Real Component',
                $this->getAssertionPrecision($expected->getReal())
            );
            $this->assertEquals(
                $expected->getImaginary(),
                $result->getImaginary(),
                'Imaginary Component',
                $this->getAssertionPrecision($expected->getImaginary())
            );
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
            [2.3, -4.5, 'J']
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

    public function testInvalidComplex()
    {
        $this->expectException(Exception::class);

        $complex = new Complex('ABCDEFGHI');
    }

    public function testReal()
    {
        $complex = new Complex('0.0');
        $this->assertTrue($complex->isReal());

        $complex = new Complex('-i');
        $this->assertFalse($complex->isReal());

        $complex = new Complex('2.5i');
        $this->assertFalse($complex->isReal());

        $complex = new Complex('1.5E64+2.5E-128i');
        $this->assertFalse($complex->isReal());
    }

    public function testComplex()
    {
        $complex = new Complex('0.0');
        $this->assertFalse($complex->isComplex());

        $complex = new Complex('-i');
        $this->assertTrue($complex->isComplex());

        $complex = new Complex('2.5i');
        $this->assertTrue($complex->isComplex());

        $complex = new Complex('1.5E64+2.5E-128i');
        $this->assertTrue($complex->isComplex());
    }

    /**
     * @dataProvider providerAdd
     */
    public function testAdd()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->add(
            new Complex($args[1])
        );

        $expected = new Complex($args[2]);
        $this->assertEquals($expected->getReal(), $result->getReal());
        $this->assertEquals($expected->getImaginary(), $result->getImaginary());

        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    public function testAddInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Suffix Mismatch');

        $complex = new Complex('12.34+56.78i');
        $result = $complex->add(
            new Complex(23),
            new Complex('34.56-78.90j')
        );
    }

    /**
     * @dataProvider providerSubtract
     */
    public function testSubtract()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->subtract(
            new Complex($args[1])
        );

        $expected = new Complex($args[2]);
        $this->assertEquals($expected->getReal(), $result->getReal());
        $this->assertEquals($expected->getImaginary(), $result->getImaginary());

        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    public function testSubtractInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Suffix Mismatch');

        $complex = new Complex('12.34+56.78i');
        $result = $complex->subtract(
            new Complex(23),
            new Complex('34.56-78.90j')
        );
    }

    /**
     * @dataProvider providerMultiply
     */
    public function testMultiply()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->multiply(
            new Complex($args[1])
        );

        $expected = new Complex($args[2]);
        $this->assertEquals($expected->getReal(), $result->getReal());
        $this->assertEquals($expected->getImaginary(), $result->getImaginary());

        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    public function testMultiplyInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Suffix Mismatch');

        $complex = new Complex('12.34+56.78i');
        $result = $complex->multiply(
            new Complex(23),
            new Complex('34.56-78.90j')
        );
    }

    /**
     * @dataProvider providerDivideBy
     */
    public function testDivideBy()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->divideBy(
            new Complex($args[1])
        );

        $expected = new Complex($args[2]);
        $this->assertEquals($expected->getReal(), $result->getReal());
        $this->assertEquals($expected->getImaginary(), $result->getImaginary());

        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    public function testDivideByZero()
    {
        $this->expectException(\InvalidArgumentException::class);

        $complex = new Complex('2.5-i');
        $complex->divideBy(0.0);
    }

    public function testDivideByInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Suffix Mismatch');

        $complex = new Complex('12.34+56.78i');
        $result = $complex->divideBy(
            new Complex(23),
            new Complex('34.56-78.90j')
        );
    }

    /**
     * @dataProvider providerDivideInto
     */
    public function testDivideInto()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->divideInto(
            new Complex($args[1])
        );

        $expected = new Complex($args[2]);
        $this->assertEquals($expected->getReal(), $result->getReal());
        $this->assertEquals($expected->getImaginary(), $result->getImaginary());

        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    public function testDivideIntoByZero()
    {
        $this->expectException(\InvalidArgumentException::class);

        $complex = new Complex(0.0);
        $complex->divideInto(
            new Complex('2.5-i')
        );
    }

    public function testDivideIntoInvalid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Suffix Mismatch');

        $complex = new Complex('12.34+56.78i');
        $result = $complex->divideInto(
            new Complex(23),
            new Complex('34.56-78.90j')
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

        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    public function testValidateComplexArgument()
    {
        $this->expectException(Exception::class);

        $nonComplex = new \stdClass();
        Complex::validateComplexArgument($nonComplex);
    }


    public function testInvalidInvocation()
    {
        $this->expectException(Exception::class);

        $complex = new Complex('1.2+3.4i');
        $complex->someInvalidFunction();
    }

    private $oneComplexValueDataSets = [
        [12,       null,       null],
        [12.345,   null,       null],
        [0.12345,  null,       null],
        [12.345,   6.789,      null],
        [12.345,   -6.789,     null],
        [0.12345,  6.789,      null],
        [0.12345,  -6.789,     null],
        [0.12345,  0.6789,     null],
        [0.12345,  -0.6789,    null],
        [-9.8765,  null,       null],
        [-0.98765, null,       null],
        [-9.8765,  +4.321,     null],
        [-9.8765,  -4.321,     null],
        [-0.98765, 0.4321,     null],
        [-0.98765, -0.4321,    null],
        [0,        M_PI,       null],
        [0,        -M_PI,      null],
        [0,        1,          null],
        [0,        -1,         null],
        [0,        0.123,      null],
        [0,        -0.123,     null],
    ];

    private function formatOneArgumentTestResultArray($expectedResults)
    {
        $testValues = [];
        foreach ($this->oneComplexValueDataSets as $test => $dataSet) {
            $testValues[$test][] = $dataSet;
            $testValues[$test][] = $expectedResults[$test];
        }

        return $testValues;
    }

    private $twoComplexValueDataSets = [
        [123,      null,   null,   456,        null,   null],
        [123.456,  null,   null,   789.012,    null,   null],
        [123.456,  78.90,  null,   -987.654,   -32.1,  null],
        [123.456,  78.90,  null,   -987.654,   null,   null],
        [-987.654, -32.1,  null,   0,          1,      null],
        [-987.654, -32.1,  null,   0,          -1,     null],
    ];

    private function formatTwoArgumentTestResultArray($expectedResults)
    {
        $testValues = [];
        foreach ($this->twoComplexValueDataSets as $test => $dataSet) {
            $testValues[$test][] = array_slice($dataSet, 0, 3);
            $testValues[$test][] = array_slice($dataSet, 3, 3);
            $testValues[$test][] = $expectedResults[$test];
        }

        return $testValues;
    }

    public function providerAdd()
    {
        $expectedResults = [
            579,
            912.468,
            '-864.198+46.8i',
            '-864.198+78.9i',
            '-987.654-31.1i',
            '-987.654-33.1i',
        ];

        return $this->formatTwoArgumentTestResultArray($expectedResults);
    }

    public function providerSubtract()
    {
        $expectedResults = [
            -333,
            -665.556,
            '1111.11+111i',
            '1111.11+78.9i',
            '-987.654-33.1i',
            '-987.654-31.1i',
        ];

        return $this->formatTwoArgumentTestResultArray($expectedResults);
    }

    public function providerMultiply()
    {
        $expectedResults = [
            56088,
            97408.265472,
            '-119399.122224-81888.8382i',
            '-121931.812224-77925.9006i',
            '32.1-987.654i',
            '-32.1+987.654i',
        ];

        return $this->formatTwoArgumentTestResultArray($expectedResults);
    }

    public function providerDivideBy()
    {
        $expectedResults = [
            0.26973684210526,
            0.15646910313151,
            '-0.127461004165656-0.07574363265504158i',
            '-0.1249992406247532-0.0798862759630397i',
            '-32.1+987.654i',
            '32.1-987.654i',
        ];

        return $this->formatTwoArgumentTestResultArray($expectedResults);
    }

    public function providerDivideInto()
    {
        $expectedResults = [
            3.7073170731707,
            6.3910381026439,
            '-5.798055462132258+3.44549131643853i',
            '-5.680072608981408+3.630100836319281i',
            '-3.287281241324573E-5-0.001011431921220928i',
            '3.287281241324573E-5+0.001011431921220928i',
        ];

        return $this->formatTwoArgumentTestResultArray($expectedResults);
    }

    /*
     */
    public function providerNegative()
    {
        $expectedResults = [
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
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
