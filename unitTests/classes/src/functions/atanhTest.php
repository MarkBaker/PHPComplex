<?php

namespace Complex;

class atanhTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'atanh';

    /**
     * @dataProvider dataProvider
     */
    public function testAtanhStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::atanh($complex);
        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testAtanhInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->atanh();
        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha utang
     *  N[ArcTanh[<VALUE>], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            '0.08352704233158310-1.57079632679489662i',
            '0.08118233231234121-1.57079632679489662i',
            0.124082919526178230,
            '0.06220185236712153+1.53647383617240851i',
            '0.06220185236712153-1.53647383617240851i',
            '0.00262072256421015+1.42459748928464954i',
            '0.00262072256421015-1.42459748928464954i',
            '0.084423222108281457+0.601290456468997789i',
            '0.084423222108281457-0.601290456468997789i',
            '-0.10159858166645237+1.57079632679489662i',
            -2.54052612615238432,
            '-0.08507023405349073+1.53336304554086626i',
            '-0.08507023405349073-1.53336304554086626i',
            '-0.774365673480939215+0.878142243314273647i',
            '-0.774365673480939215-0.878142243314273647i',
            '0.785398163397448310i',
            '-0.785398163397448310i',
            '0.122385281471802660i',
            '-0.122385281471802660i',
            -INF,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
