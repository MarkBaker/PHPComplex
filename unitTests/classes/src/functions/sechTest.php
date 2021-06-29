<?php

namespace Complex;

class sechTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'sech';

    /**
     * @dataProvider dataProvider
     */
    public function testSechStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::sech($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testSechInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->sech();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[SecH[<VALUE> Radians], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            0.0000122884247061925150,
            8.70291248914586449E-6,
            0.992428137094912224,
            '7.61313404486084631E-6-4.21673757898906154E-6i',
            '7.61313404486084631E-6+4.21673757898906154E-6i',
            '1.129262343994501309-0.076824660290879901i',
            '1.129262343994501309+0.076824660290879901i',
            '1.262779988289303536-0.125143929704716813i',
            '1.262779988289303536+0.125143929704716813i',
            0.000102735501200864480,
            0.654157342332210739,
            '-0.0000391907923113348644-0.0000949666525691565824i',
            '-0.0000391907923113348644+0.0000949666525691565824i',
            '0.642230116463789304+0.224013845814869186i',
            '0.642230116463789304-0.224013845814869186i',
            1.85081571768092562,
            1.85081571768092562,
            1.00761247990586674,
            1.00761247990586674,
            0.648054273663885400,
        ];
        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
