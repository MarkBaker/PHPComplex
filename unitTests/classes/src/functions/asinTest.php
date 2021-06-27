<?php

namespace Complex;

class asinTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'asin';

    /**
     * @dataProvider dataProvider
     */
    public function testAsinStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::asin($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testAsinInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->asin();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[ArcSin[<VALUE>], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            '1.57079632679489662-3.17631318059165577i',
            '1.57079632679489662-3.20475382161825604i',
            0.123765731093054622,
            '1.06693397480248384+3.33784183956736074i',
            '1.06693397480248384-3.33784183956736074i',
            '0.01798783911138186+2.61399140081652779i',
            '0.01798783911138186-2.61399140081652779i',
            '0.102144960968324714+0.638235687812878915i',
            '0.102144960968324714-0.638235687812878915i',
            '-1.57079632679489662+2.98073255621495518i',
            -1.41347179299060679,
            '-1.15679641219396815+3.06941431940712748i',
            '-1.15679641219396815-3.06941431940712748i',
            '-0.928795882626759563+0.670281385591987313i',
            '-0.928795882626759563-0.670281385591987313i',
            '0.881373587019543025i',
            '-0.881373587019543025i',
            '0.122691948158259558i',
            '-0.122691948158259558i',
            -1.57079632679489662,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
