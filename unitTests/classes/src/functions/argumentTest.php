<?php

namespace Complex;
include_once __DIR__ . '/baseFunctionTest.php';

class argumentTest extends baseFunctionTest
{
    protected static $functionName = 'argument';

    /**
     * @dataProvider providerArgument
     */
	public function testArgument()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = argument($complex);

        $this->assertEquals($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Argument[<VALUE>], 18]
     */
    public function providerArgument()
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
            M_PI / 2, // 1.57079632679489662
            -M_PI / 2, // -1.57079632679489662
		);

		return $this->formatOneArgumentTestResultArray($expectedResults);
	}

}
