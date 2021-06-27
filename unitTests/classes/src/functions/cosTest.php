<?php

namespace Complex;

class cosTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'cos';

    /**
     * @dataProvider dataProvider
     */
    public function testCosStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::cos($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testCosInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->cos();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[Cosine[<VALUE> Radians], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            0.843853958732492105,
            0.975597424116876431,
            0.992389721111488176,
            '433.178045742218089+97.490377676007900i',
            '433.178045742218089-97.490377676007900i',
            '440.634045743687350-54.674160542549849i',
            '440.634045743687350+54.674160542549849i',
            '1.230008626496005725-0.090168869210320139i',
            '1.230008626496005725+0.090168869210320139i',
            -0.899696739907973162,
            0.550653004753812240,
            '-33.8632992264903040-16.4240194053061343i',
            '-33.8632992264903040+16.4240194053061343i',
            '0.602864164806169264+0.372017973792045322i',
            '0.602864164806169264-0.372017973792045322i',
            1.54308063481524378,
            1.54308063481524378,
            1.00757404175415510,
            1.00757404175415510,
            0.540302305868139717,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
