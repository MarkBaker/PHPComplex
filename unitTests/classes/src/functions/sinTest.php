<?php

namespace Complex;

class sinTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'sin';

    /**
     * @dataProvider dataProvider
     */
    public function testSinStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::sin($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testSinInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->sin();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[Sine[<VALUE> Radians], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            -0.536572918000434972,
            -0.219566996737933121,
            0.123136677851332009,
            '-97.490624929152629+433.176947127514213i',
            '-97.490624929152629-433.176947127514213i',
            '54.674299206061591+440.632928219273450i',
            '54.674299206061591-440.632928219273450i',
            '0.152620661795611862+0.726693788804372014i',
            '0.152620661795611862-0.726693788804372014i',
            0.436515493652819720,
            -0.834734250139287165,
            '16.42981920783279-33.85134532450693i',
            '16.42981920783279+33.85134532450693i',
            '-0.913881087001989+0.245410817942156i',
            '-0.913881087001989-0.245410817942156i',
            '1.17520119364380146i',
            '-1.17520119364380146i',
            '0.123310379193334229i',
            '-0.1233103791933342i',
            -0.841470984807896507,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
