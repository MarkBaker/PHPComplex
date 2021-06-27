<?php

namespace Complex;

class log2Test extends BaseFunctionTestAbstract
{
    protected static $functionName = 'log2';

    /**
     * @dataProvider dataProvider
     */
    public function testLog2Static()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::log2($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testLog2Invoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->log2();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    public function testLog2Zero()
    {
        $this->expectException(\InvalidArgumentException::class);

        $complex = new Complex(0);
        Functions::log2($complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[Log2[<VALUE>], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            3.58496250072115618,
            3.62585493136805716,
            -3.01800125840666753,
            '3.81645960781299948+0.72538211247550245i',
            '3.81645960781299948-0.72538211247550245i',
            '2.76343756058230524+2.23994924502863563i',
            '2.76343756058230524-2.23994924502863563i',
            '-0.53526338548893765+2.00667826814293056i',
            '-0.53526338548893765-2.00667826814293056i',
            '3.30399987508548900+4.53236014182719381i',
            '-0.01792821980187335+4.53236014182719381i',
            '3.43033426756814311+3.93737381149188807i',
            '3.43033426756814311-3.93737381149188807i',
            '0.10840617268078076+3.93737381149188807i',
            '0.10840617268078076-3.93737381149188807i',
            '2.26618007091359690i',
            '-2.26618007091359690i',
            '-3.02326977932284717+2.26618007091359690i',
            '-3.02326977932284717-2.26618007091359690i',
            '4.53236014182719381i',
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
