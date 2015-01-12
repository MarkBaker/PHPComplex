<?php

namespace Complex;
include_once __DIR__ . '/baseFunctionTest.php';

class conjugateTest extends baseFunctionTest
{
    protected static $functionName = 'conjugate';

    /**
     * @dataProvider providerConjugate
     */
	public function testConjugate()
	{
		$args = func_get_args();
		$complex = new Complex($args[0]);
		$result = conjugate($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
	}

    /*
     * Results derived from Wolfram Alpha using
     *  N[Conjugate[<VALUE>], 18]
     */
    public function providerConjugate()
    {
		$expectedResults = array(
			12,
			12.345,
			0.12345,
            '12.345-6.789i',
            '12.345+6.789i',
            '0.12345-6.789i',
            '0.12345+6.789i',
            '0.12345-0.6789i',
            '0.12345+0.6789i',
			-9.8765,
            -0.98765,
			'-9.8765-4.321i',
			'-9.8765+4.321i',
			'-0.98765-0.4321i',
			'-0.98765+0.4321i',
            '-3.14159265358979324i',
            '3.14159265358979324i',
			'-i',
			'i',
            '-0.123i',
            '0.123i',
		);

		return $this->formatOneArgumentTestResultArray($expectedResults);
	}

}
