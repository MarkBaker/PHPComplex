<?php

namespace Complex;

use PHPUnit\Framework\TestCase;

abstract class BaseTestAbstract extends TestCase
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

    // Overload the older setExpectedException() method from PHPUnit, converting to the newer
    //    expectException() and expectExceptionMessage() methods if available
    //    (for backward compatibility with PHPUnit when testing against PHP versions prior to PHP7)
    public function setExpectedException($exception, $message = '', $code = null)
    {
        if (!method_exists($this, 'expectException')) {
            return parent::setExpectedException($exception, $message);
        }

        $this->expectException($exception);
        if (!empty($message)) {
            $this->expectExceptionMessage($message);
        }
    }

    protected function getAssertionPrecision($value)
    {
        return \pow(10, \floor(\log10($value)) - $this->significantDigits + 1);
    }

    protected function complexNumberAssertions($expected, $result)
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
        [0,        1,          null],
        [0,        -1,         null],
        [0,        0.123,      null],
        [0,        -0.123,     null],
        [-1,       null,       null],
    ];

    protected function formatOneArgumentTestResultArray($expectedResults)
    {
        $testValues = array();
        foreach ($this->oneComplexValueDataSets as $test => $dataSet) {
            $testValues[$test][] = $dataSet;
            $testValues[$test][] = $expectedResults[$test];
        }

        return $testValues;
    }

    abstract public function dataProvider();

    public function dataProviderInvoker()
    {
        $tests = $this->dataProvider();
        return [array_pop($tests)];
    }
}
