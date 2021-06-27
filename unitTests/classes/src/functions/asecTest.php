<?php

namespace Complex;

class asecTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'asec';

    /**
     * @dataProvider dataProvider
     */
    public function testAsecStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::asec($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testAsecInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->asec();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[ArcSec[<VALUE> Radians], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            1.48736624018428161,
            1.48970302082660277,
            '2.78123430803937039i',
            '1.50859800830252214+0.03426287528025610i',
            '1.50859800830252214-0.03426287528025610i',
            '1.56814734798028957+0.14672193818647115i',
            '1.56814734798028957-0.14672193818647115i',
            '1.42248128431339558+1.16195623593418560i',
            '1.42248128431339558-1.16195623593418560i',
            1.67222057013667903,
            '3.14159265358979324-0.15797756885066499i',
            '1.65582341680235061+0.03730682535518739i',
            '1.65582341680235061-0.03730682535518739i',
            '2.40822472454593001+0.53025304749856957i',
            '2.40822472454593001-0.53025304749856957i',
            '1.57079632679489662+0.88137358701954303i',
            '1.57079632679489662-0.88137358701954303i',
            '1.57079632679489662+2.79247907463123116i',
            '1.57079632679489662-2.79247907463123116i',
            M_PI, // 3.141592653589793
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
