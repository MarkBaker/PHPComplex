<?php

namespace Complex;
include_once __DIR__ . '/baseFunctionTest.php';

class acscTest extends baseFunctionTest
{
    public function testFunctionExists() {
        $this->namespaced_function_exists('acsc'); 
    }

    /**
     * @dataProvider providerACsc
     */
	public function testAcsc()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = acsc($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[ArcCoSec[<VALUE> Radians], 18]
     */
    public function providerACsc()
    {
		$expectedResults = array(
			0.0834300866106150049,
            0.0810933059682938455,
            '1.57079632679489662-2.78123430803937039i',
            '0.0621983184923744794-0.0342628752802560973i',
            '0.0621983184923744794+0.0342628752802560973i',
            '0.002648978814607050-0.146721938186471153i',
            '0.002648978814607050+0.146721938186471153i',
            '0.148315042481501040-1.161956235934185596i',
            '0.148315042481501040+1.161956235934185596i',
            -0.101424243341782414,
            '-1.57079632679489662+0.15797756885066499i',
            '-0.085027090007454-0.03730682535518739i',
            '-0.085027090007454+0.03730682535518738i',
            '-0.837428397751033-0.5302530474985694i',
            '-0.837428397751033+0.5302530474985694i',
            '-0.313165880450868376i',
            '0.313165880450868376i',
            '-0.881373587019543025i',
            '0.88137358701954303i',
            '-2.79247907463123116i',
            '2.792479074631231i',
		);

		return $this->formatOneArgumentTestResultArray($expectedResults);
	}

}
