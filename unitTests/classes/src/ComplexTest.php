<?php

namespace Complex;

use Complex\Complex as Complex;

class ComplexTest extends \PHPUnit\Framework\TestCase
{
    // Saved php.ini precision, so that we can adjust the setting
    private static $precision;

    // Number of significant digits used for assertEquals
    private $significantDigits = 12;

    /**
     * @beforeClass
     */
    public static function setPrecision()
    {
        self::$precision = ini_set('precision', 16);
    }

    /**
     * @afterClass
     */
    public static function resetPrecision()
    {
        ini_set('precision', self::$precision);
    }

    protected function getAssertionPrecision($value)
    {
        return \pow(10, floor(\log10($value)) - $this->significantDigits + 1);
    }

    public function complexNumberAssertions($expected, $result)
    {
        if (is_numeric($expected)) {
            $this->assertEqualsWithDelta(
                $expected,
                $result->getReal(),
                $this->getAssertionPrecision($expected),
                'Numeric Assertion'
            );
        } else {
            $expected = new Complex($expected);
            $this->assertEqualsWithDelta(
                $expected->getReal(),
                $result->getReal(),
                $this->getAssertionPrecision($expected->getReal()),
                'Real Component'
            );
            $this->assertEqualsWithDelta(
                $expected->getImaginary(),
                $result->getImaginary(),
                $this->getAssertionPrecision($expected->getImaginary()),
                'Imaginary Component'
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

    /**
     * @dataProvider providerArguments
     */
    public function testInstantiateWithEmptyArguments($expected, $arguments)
    {
        $complexObject = new Complex(...$arguments);

        $defaultComplexReal = $complexObject->getReal();
        $this->assertEquals($expected[0], $defaultComplexReal);

        $defaultComplexImaginary = $complexObject->getImaginary();
        $this->assertEquals($expected[1], $defaultComplexImaginary);

        $defaultComplexSuffix = $complexObject->getSuffix();
        $this->assertEquals($expected[2], $defaultComplexSuffix);
    }

    public function providerArguments()
    {
        return [
            'Imaginary with suffix' => [[0.0, 2.34, 'j'], [null, 2.34, 'j']],
            'Imaginary without suffix' => [[0.0, 2.34, 'i'], [null, 2.34]],
            'Imaginary with empty suffix' => [[0.0, 2.34, 'i'], [null, 2.34, '']],
            'Imaginary with null suffix' => [[0.0, 2.34, 'i'], [null, 2.34, null]],
            'Real with suffix' => [[1.23, 0.0, ''], [1.23, null, 'j']],
            'Complex with empty suffix' => [[1.23, 2.34, 'i'], [1.23, 2.34, '']],
            'Complex with null suffix' => [[1.23, 2.34, 'i'], [1.23, 2.34, null]],
        ];
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
}
