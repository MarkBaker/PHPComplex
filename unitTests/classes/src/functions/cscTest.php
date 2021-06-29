<?php

namespace Complex;

class cscTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'csc';

    /**
     * @dataProvider dataProvider
     */
    public function testCscStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::csc($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testCscInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->csc();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[CoSec[<VALUE> Radians], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            -1.86367959778243849,
            -4.55441853674194147,
            8.12105716549654890,
            '-0.00049450804976921878-0.00219723165673293340i',
            '-0.00049450804976921878+0.00219723165673293340i',
            '0.00027732805718126026-0.00223505149014498655i',
            '0.00027732805718126026+0.00223505149014498655i',
            '0.276799143639273659-1.317961906746316859i',
            '0.276799143639273659+1.317961906746316859i',
            2.29086942970080391,
            -1.19798606542517684,
            '0.01160418811259422+0.02390880715368388i',
            '0.01160418811259422-0.02390880715368388i',
            '-1.020634209071783-0.274077973196426i',
            '-1.020634209071783+0.274077973196426i',
            '-0.850918128239321545i',
            '0.85091812823932155i',
            '-8.10961742670609559i',
            '8.1096174267061i',
            -1.18839510577812122,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
