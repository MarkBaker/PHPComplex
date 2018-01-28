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
     *  N[Tanh[<VALUE> Radians], {INF,32}]
     */
    public function providerTanh()
    {
		$expectedResults = array(
			0.9999999999244973091172683731325,
			0.9999999999621296571024173850942,
            0.1228266774862941086554829621066,
			'0.99999999997991053291283312541494+3.210258842149065039302E-11i',
            '0.99999999997991053291283312541494-3.210258842149065039302E-11i',
			'0.15976793499766698586005810639918+0.54300755629048575024995016767170i',
			'0.15976793499766698586005810639918-0.54300755629048575024995016767170i',
            '0.20081420429827777353626011496473+0.78694259023765190746071322771649i',
            '0.20081420429827777353626011496473-0.78694259023765190746071322771649i',
            -0.9999999947227083825786830543459,
            -0.7563584940177897203379175583806,
            '-1.000000003741373+0.0000000037218183434158i',
            '-1.000000003741373-0.0000000037218183434158i',
            '-0.817726452647815+0.1759371215414836i',
            '-0.817726452647815-0.1759371215414836i',
            '1.53735661672049712E-18i',
            0.0,
			'1.55740772465490223050697480745836i',
			'-1.55740772465490223050697480745836i',
            '0.12362406586927441783085053209750i',
            '-0.12362406586927441783085053209750i',
		);

		return $this->formatOneArgumentTestResultArray($expectedResults);
	}

}