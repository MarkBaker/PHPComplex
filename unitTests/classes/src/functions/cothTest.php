<?php

namespace Complex;

class cothTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'coth';

    /**
     * @dataProvider dataProvider
     */
    public function testCothStatic()
    {
        $args = func_get_args();
        if (strpos($args[1], 'Exception') !== false) {
            $this->setExpectedException($args[1]);
        }
        $complex = new Complex($args[0]);
        $result = Functions::coth($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testCothInvoker()
    {
        $args = func_get_args();
        if (strpos($args[1], 'Exception') !== false) {
            $this->setExpectedException($args[1]);
        }
        $complex = new Complex($args[0]);
        $result = $complex->coth();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[Coth[<VALUE> Radians], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            1.00000000007550269,
            1.00000000003787034,
            8.14155377696011725,
            '1.00000000002008946708653988508949-3.210258842278049818004E-11i',
            '1.00000000002008946708653988508949+3.210258842278049818004E-11i',
            '0.49867794288608618-1.69487006980777610i',
            '0.49867794288608618+1.69487006980777610i',
            '0.304446159249399012-1.193051308222032128i',
            '0.304446159249399012+1.193051308222032128i',
            -1.00000000527729165,
            -1.32212437344093577,
            '-0.999999996258627-3.721818315566377E-9i',
            '-0.999999996258627+3.721818315566377E-9i',
            '-1.168797734949383-0.251471514080718i',
            '-1.168797734949383+0.251471514080718i',
            '-0.642092615934330703i',
            '0.6420926159343307i',
            '-8.08903988853953767i',
            '8.08903988853954i',
            -1.31303528549933130,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
