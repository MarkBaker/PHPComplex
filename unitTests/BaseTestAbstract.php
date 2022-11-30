<?php

namespace Complex;

use PHPUnit\Framework\TestCase;

abstract class BaseTestAbstract extends TestCase
{
    // Saved php.ini precision, so that we can adjust the setting
    private static $precision;

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
        if ($value === 0.0) {
            return \pow(10, -10);
        } elseif ($value > 10) {
            return \pow(10, -8);
        }

        return 1.0e-11;
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
            $name = 'value ' . (new Complex($dataSet))->format();
            $testValues[$name][] = $dataSet;
            $testValues[$name][] = $expectedResults[$test];
        }

        return $testValues;
    }

    abstract public function dataProvider();

    public function dataProviderInvoker()
    {
        return $this->dataProvider();
    }
}
