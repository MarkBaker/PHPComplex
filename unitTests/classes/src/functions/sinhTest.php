<?php

namespace Complex;

class sinhTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'sinh';

    /**
     * @dataProvider dataProvider
     */
    public function testSinhStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::sinh($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testSinhInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->sinh();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[SinH[<VALUE> Radians], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            81377.3957064298542,
            114904.062428447249,
            0.123763800012602234,
            '100515.7791305250211+55673.3482788557751i',
            '100515.7791305250211-55673.3482788557751i',
            '0.108266100636502154+0.488216990166093592i',
            '0.108266100636502154-0.488216990166093592i',
            '0.096320900214579535+0.632728245310258886i',
            '0.096320900214579535-0.632728245310258886i',
            -9733.73354910243784,
            -1.15623328681324593,
            '3713.15389556070345-8997.66957646719047i',
            '3713.15389556070345+8997.66957646719047i',
            '-1.049961939903045305+0.640180401259003748i',
            '-1.049961939903045305-0.640180401259003748i',
            '0.841470984807896507i',
            '-0.841470984807896507i',
            '0.122690090024315336i',
            '-0.123310379193334229i',
            -1.17520119364380146,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
