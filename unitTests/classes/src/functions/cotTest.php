<?php

namespace Complex;

class cotTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'cot';

    /**
     * @dataProvider dataProvider
     */
    public function testCotStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::cot($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testCotInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->cot();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[Cot[<VALUE> Radians], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            -1.57267340639768934,
            -4.44327899279559163,
            8.05925365559757284,
            '-1.086546251487E-6-1.000002291642335510i',
            '-1.086546251487E-6+1.000002291642335510i',
            '6.19840963106E-7-1.000002459269324248i',
            '6.19840963106E-7+1.000002459269324248i',
            '0.22162619968942080-1.64606318047143227i',
            '0.22162619968942080+1.64606318047143227i',
            -2.06108775745665098,
            -0.659674626579570722,
            '-2.773816874338468E-4-1.000218501537719i',
            '-2.773816874338468E-4+1.000218501537719i',
            '-0.5133418577751009-0.5449260588445627i',
            '-0.5133418577751009+0.5449260588445627i',
            '-1.31303528549933130i',
            '1.3130352854993313i',
            '-8.17104000770619135i',
            '8.17104000770619i',
            -0.642092615934330703,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
