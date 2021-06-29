<?php

namespace Complex;

class acoshTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'acosh';

    /**
     * @dataProvider dataProvider
     */
    public function testAcoshStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::acosh($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testAcoshInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->acosh();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[ArcCosH[<VALUE>], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            3.17631318059165577,
            3.20475382161825604,
            '1.44703059570184200i',
            '3.33784183956736074+0.50386235199241278i',
            '3.33784183956736074-0.50386235199241278i',
            '2.61399140081652779+1.55280848768351476i',
            '2.61399140081652779-1.55280848768351476i',
            '0.63823568781287892+1.46865136582657190i',
            '0.63823568781287892-1.46865136582657190i',
            '2.98073255621495518+3.14159265358979324i',
            '2.98426811978550341i',
            '3.06941431940712748+2.72759273898886477i',
            '3.06941431940712748-2.72759273898886477i',
            '0.67028138559198731+2.49959220942165618i',
            '0.67028138559198731-2.49959220942165618i',
            '0.88137358701954303+1.57079632679489662i',
            '0.88137358701954303-1.57079632679489662i',
            '0.12269194815825956+1.57079632679489662i',
            '0.12269194815825956-1.57079632679489662i',
            '3.14159265358979324i'
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
