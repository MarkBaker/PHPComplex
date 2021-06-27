<?php

namespace Complex;

class inverseTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'inverse';

    /**
     * @dataProvider dataProvider
     */
    public function testInverseStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::inverse($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testInverseInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->inverse();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[1 / (<VALUE>), 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            0.0833333333333333333,
            0.0810044552450384771,
            8.10044552450384771,
            '0.0621947112519467398-0.0342033126520426421i',
            '0.0621947112519467398+0.0342033126520426421i',
            '0.002677539586887203-0.147248410331123696i',
            '0.002677539586887203+0.147248410331123696i',
            '0.25926969900378847-1.42582582951536649i',
            '0.25926969900378847+1.42582582951536649i',
            '-0.101250442970687997',
            '-1.01250442970687997',
            '-0.0849837808779019890-0.0371806730292527206i',
            '-0.0849837808779019890+0.0371806730292527206i',
            '-0.849837808779019890-0.371806730292527206i',
            '-0.849837808779019890+0.371806730292527206i',
            '-1.0i',
            '1.0i',
            '-8.13008130081300813i',
            '8.13008130081300813i',
            -1.0,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
