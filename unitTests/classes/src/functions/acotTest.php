<?php

namespace Complex;

class acotTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'acot';

    /**
     * @dataProvider dataProvider
     */
    public function testAcotStatic()
    {
        $args = func_get_args();
        if (strpos($args[1], 'Exception') !== false) {
            $this->setExpectedException($args[1]);
        }
        $complex = new Complex($args[0]);
        $result = Functions::acot($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testAcotInvoker()
    {
        $args = func_get_args();
        if (strpos($args[1], 'Exception') !== false) {
            $this->setExpectedException($args[1]);
        }
        $complex = new Complex($args[0]);
        $result = $complex->acot();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha ucotg
     *  N[ArcCot[<VALUE>], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            0.0831412318884412299,
            0.0808279733084775996,
            1.44796777610748119,
            '0.0621869868281412105-0.0340845578374814375i',
            '0.0621869868281412105+0.0340845578374814375i',
            '0.002736873618689962-0.148325588129304989i',
            '0.002736873618689962+0.148325588129304989i',
            '1.35057813906631677-0.79395500361362078i',
            '1.35057813906631677+0.79395500361362078i',
            -0.100906560945183776,
            -0.791611450986264429,
            '-0.0848960316219556861-0.0369304870575309931i',
            '-0.0848960316219556861+0.0369304870575309931i',
            '-0.744442335995596569-0.211641371433262802i',
            '-0.744442335995596569+0.211641371433262802i',
            'InvalidArgumentException',
            'InvalidArgumentException',
            '-1.57079632679489662-0.12362598118313007i',
            '1.57079632679489662+0.12362598118313007i',
            -0.785398163397448310,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
