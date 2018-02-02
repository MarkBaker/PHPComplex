<?php

namespace Complex;

abstract class BaseFunctionTestAbstract extends \PHPUnit\Framework\TestCase
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

    public function setExpectedException($exception, $message = '', $code = null) {
        if (!method_exists($this,'expectException')) {
            return parent::setExpectedException($exception, $message);
        }

        $this->expectException($exception);
        if (!empty($message)) {
            $this->expectExceptionMessage($message);
        }
    }

    public function testNamespacedFunctionExists() {
        $this->assertTrue(function_exists('\\' . __NAMESPACE__ . '\\' . static::$functionName)); 
    }

    /**
     * @expectedException \Exception
     */
    public function testInvalidArgument()
    {
        $invalidComplex = '*** INVALID ***';
        $result = call_user_func('\\' . __NAMESPACE__ . '\\' . static::$functionName, $invalidComplex);
    }

    protected function getAssertionPrecision($value)
    {
        return pow(10, floor(\log10($value)) - $this->significantDigits + 1);
    }

    protected function complexNumberAssertions($expected, $result)
    {
        if (is_numeric($expected)) {
            $this->assertEquals($expected, (string) $result, null, $this->getAssertionPrecision($expected));
        } else {
            $expected = new Complex($expected);
            $this->assertEquals($expected->getReal(), $result->getReal(), 'Real Component', $this->getAssertionPrecision($expected->getReal()));
            $this->assertEquals($expected->getImaginary(), $result->getImaginary(), 'Imaginary Component', $this->getAssertionPrecision($expected->getImaginary()));
        }
    }

    private $oneComplexValueDataSets = array(
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
        array(0,        1,          NULL),
        array(0,        -1,         NULL),
        array(0,        0.123,      NULL),
        array(0,        -0.123,     NULL),
    );

    protected function formatOneArgumentTestResultArray($expectedResults)
    {
        $testValues = array();
        foreach($this->oneComplexValueDataSets as $test => $dataSet) {
            $testValues[$test][] = $dataSet;
            $testValues[$test][] = $expectedResults[$test];
        }

        return $testValues;
    }

    abstract public function dataProvider();

    public function dataProviderInvoker()
    {
        $tests = $this->dataProvider();
        return array(array_pop($tests));
    }
}
