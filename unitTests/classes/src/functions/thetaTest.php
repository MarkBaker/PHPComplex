<?php

namespace Complex;
include_once __DIR__ . '/baseFunctionTest.php';

class thetaTest extends baseFunctionTest
{
    protected static $functionName = 'theta';

    /**
     * @dataProvider dataProvider
     */
	public function testTheta()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = theta($complex);

        $this->assertEquals($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
	}

    /**
     * @dataProvider dataProviderInvoker
     */
	public function testThetaInvoker()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = $complex->theta();

        $this->assertEquals($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Argument[<VALUE>], 18]
     */
    public function dataProvider()
    {
		$expectedResults = array(
			0.0,
			0.0,
            0.0,
			0.502796566091011651,
			-0.502796566091011651,
            1.55261450378897688,
            -1.55261450378897688,
            1.39092338385418624,
            -1.39092338385418624,
            M_PI, // 3.141592653589793
            M_PI, // 3.141592653589793
            2.72917955624616780,
            -2.72917955624616780,
            2.72917955624616780,
            -2.72917955624616780,
            M_PI / 2, // 1.57079632679489662
            -M_PI / 2, // -1.57079632679489662
            M_PI / 2, // 1.57079632679489662
            -M_PI / 2, // -1.57079632679489662
		);

		return $this->formatOneArgumentTestResultArray($expectedResults);
	}

}
