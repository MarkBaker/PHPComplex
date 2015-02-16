<?php

namespace Complex;
include_once __DIR__ . '/baseFunctionTest.php';

class tanhTest extends baseFunctionTest
{
    protected static $functionName = 'tanh';

    /**
     * @dataProvider providerTanh
     */
	public function testTanh()
	{
		$args = func_get_args();
        if (strpos($args[1], 'Exception') !== false) {
            $this->setExpectedException($args[1]);
        }
		$complex = new Complex($args[0]);
		$result = tanh($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Tanh[<VALUE> Radians], 18]
     */
    public function providerTanh()
    {
		$expectedResults = array(
			0.99999999992449731,
			0.99999999996212966,
            0.122826677486294109,
			'0.999999999979910533+3.2102588E-11i',
            '0.999999999979910533-3.2102588E-11i',
			'0.159767934997666986+0.543007556290485750i',
			'0.159767934997666986-0.543007556290485750i',
            '0.200814204298277774+0.786942590237651907i',
            '0.200814204298277774-0.786942590237651907i',
            -0.999999994722708383,
            -0.756358494017789720,
            '-1.000000003741373+3.7218183434158E-9i',
            '-1.000000003741373-3.7218183434158E-9i',
            '-0.817726452647815+0.1759371215414836i',
            '-0.817726452647815-0.1759371215414836i',
            '1.53735661672049712E-18i',
            0.0,
			'1.55740772465490223i',
			'-1.55740772465490223i',
            '0.123624065869274418i',
            '-0.1236240658692744i',
		);

		return $this->formatOneArgumentTestResultArray($expectedResults);
	}

}
