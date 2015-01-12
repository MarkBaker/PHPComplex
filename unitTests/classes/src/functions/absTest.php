<?php

namespace Complex;
include_once __DIR__ . '/baseFunctionTest.php';

class absTest extends baseFunctionTest
{
    public function testFunctionExists() {
        $this->namespaced_function_exists('abs'); 
    }

    /**
     * @dataProvider providerAbs
     */
	public function testAbs()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = abs($complex);

        $this->assertEquals($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
        
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

		return $this->formatOneArgumentTestResultArray($expectedResults);
	}

}
