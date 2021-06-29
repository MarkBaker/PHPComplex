<?php

namespace Complex;

class atanTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'atan';

    /**
     * @dataProvider dataProvider
     */
    public function testAtanStatic()
    {
        $args = func_get_args();
        if (strpos($args[1], 'Exception') !== false) {
            $this->setExpectedException($args[1]);
        }
        $complex = new Complex($args[0]);
        $result = Functions::atan($complex);
        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testAtanInvoker()
    {
        $args = func_get_args();
        if (strpos($args[1], 'Exception') !== false) {
            $this->setExpectedException($args[1]);
        }
        $complex = new Complex($args[0]);
        $result = $complex->atan();
        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha utang
     *  N[ArcTan[<VALUE>], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            1.48765509490645539,
            1.48996835348641902,
            0.122828550687415431,
            '1.50860933996675541+0.03408455783748144i',
            '1.50860933996675541-0.03408455783748144i',
            '1.56805945317620666+0.14832558812930499i',
            '1.56805945317620666-0.14832558812930499i',
            '0.220218187728579852+0.793955003613620776i',
            '0.220218187728579852-0.793955003613620776i',
            -1.46988976584971284,
            -0.779184875808632190,
            '-1.485900295172941+0.03693048705753099i',
            '-1.485900295172941-0.036930487057531i',
            '-0.8263539907993+0.2116413714332627i',
            '-0.8263539907993-0.2116413714332627i',
            'InvalidArgumentException',
            'InvalidArgumentException',
            '0.123625981183130070i',
            '-0.1236259811831301i',
            -0.785398163397448310,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
