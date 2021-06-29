<?php

namespace Complex;

class coshTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'cosh';

    /**
     * @dataProvider dataProvider
     */
    public function testCoshStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::cosh($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testCoshInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->cosh();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[CosH[<VALUE> Radians], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            81377.3957125740666,
            114904.062432798705,
            1.00762963344353832,
            '100515.7791343315882+55673.3482767474063i',
            '100515.7791343315882-55673.3482767474063i',
            '0.881454280553858263+0.059966070794460000i',
            '0.881454280553858263-0.059966070794460000i',
            '0.784201788942208582+0.077715908123191951i',
            '0.784201788942208582-0.077715908123191951i',
            9733.73360047018858,
            1.52868420987951655,
            '-3713.15391515609948+8997.66952898386423i',
            '-3713.15391515609948-8997.66952898386423i',
            '1.38818027193114323-0.48420588419596441i',
            '1.38818027193114323+0.48420588419596441i',
            0.540302305868139717,
            0.540302305868139717,
            0.992445032135193570,
            0.992445032135193570,
            1.54308063481524378,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
