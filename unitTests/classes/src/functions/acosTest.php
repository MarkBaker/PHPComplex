<?php

namespace Complex;

class acosTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'acos';

    /**
     * @dataProvider dataProvider
     */
    public function testAcosStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::acos($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testAcosInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->acos();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[ArcCos[<VALUE>], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            '3.17631318059165577i',
            '3.20475382161825604i',
            '1.44703059570184200',
            '0.50386235199241278-3.33784183956736074i',
            '0.50386235199241278+3.33784183956736074i',
            '1.55280848768351476-2.61399140081652779i',
            '1.55280848768351476+2.61399140081652779i',
            '1.46865136582657190-0.63823568781287892i',
            '1.46865136582657190+0.63823568781287892i',
            '3.14159265358979324-2.98073255621495518i',
            2.98426811978550341,
            '2.72759273898886477-3.06941431940712748i',
            '2.72759273898886477+3.06941431940712748i',
            '2.49959220942165618-0.67028138559198731i',
            '2.49959220942165618+0.67028138559198731i',
            '1.57079632679489662-0.88137358701954303i',
            '1.57079632679489662+0.88137358701954303i',
            '1.57079632679489662-0.12269194815825956i',
            '1.57079632679489662+0.12269194815825956i',
            M_PI, // 3.141592653589793
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
