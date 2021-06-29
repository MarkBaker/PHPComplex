<?php

namespace Complex;

class asechTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'asech';

    /**
     * @dataProvider dataProvider
     */
    public function testAsechStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::asech($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testAsechInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->asech();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[ArcSecH[<VALUE> Radians], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            '1.48736624018428161i',
            '1.48970302082660277i',
            2.78123430803937039,
            '0.03426287528025610-1.50859800830252214i',
            '0.03426287528025610+1.50859800830252214i',
            '0.14672193818647115-1.56814734798028957i',
            '0.14672193818647115+1.56814734798028957i',
            '1.16195623593418560-1.42248128431339558i',
            '1.16195623593418560+1.42248128431339558i',
            '1.67222057013667903i',
            '0.15797756885066499+3.14159265358979324i',
            '0.03730682535518739-1.65582341680235061i',
            '0.03730682535518739+1.65582341680235061i',
            '0.53025304749856957-2.40822472454593001i',
            '0.53025304749856957+2.40822472454593001i',
            '0.88137358701954303-1.57079632679489662i',
            '0.88137358701954303+1.57079632679489662i',
            '2.79247907463123116-1.57079632679489662i',
            '2.79247907463123116+1.57079632679489662i',
            '3.14159265358979324i'
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
