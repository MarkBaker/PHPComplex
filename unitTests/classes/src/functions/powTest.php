<?php

namespace Complex;

class powTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'pow';

    /**
     * @dataProvider dataProvider
     */
    public function testPowStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::pow($complex, $args[1]);

        $this->complexNumberAssertions($args[2], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testPowInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->pow($args[1]);

        $this->complexNumberAssertions($args[2], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[Pow[<VALUE>, <POWER VALUE>], 18]
     */
    public function dataProvider()
    {
        return [
            // phpcs:disable Generic.Files.LineLength
            [ 'complex' => [12,       null,       null], 'power' => -5,  'expected' => 4.01877572016460905E-6],
            [ 'complex' => [12.345,   null,       null], 'power' => -5,  'expected' => 3.48774342494342341E-6],
            [ 'complex' => [0.12345,  null,       null], 'power' => -5,  'expected' => 34877.4342494342341],
            [ 'complex' => [12.345,   6.789,      null], 'power' => -5,  'expected' => '-1.45826684880998436E-6-1.05791467098023419E-6i'],
            [ 'complex' => [12.345,   -6.789,     null], 'power' => -5,  'expected' => '-1.45826684880998436E-6+1.05791467098023419E-6i'],
            [ 'complex' => [0.12345,  0.6789,     null], 'power' => -5,  'expected' => '5.00467217522872016-3.97664749734665608i'],
            [ 'complex' => [0.12345,  -0.6789,    null], 'power' => -5,  'expected' => '5.00467217522872016+3.97664749734665608i'],
            [ 'complex' => [-9.8765,  null,       null], 'power' => -5,  'expected' => -0.0000106410543072810992],
            [ 'complex' => [-0.98765, null,       null], 'power' => -5,  'expected' => -1.06410543072810992],
            [ 'complex' => [-9.8765,  +4.321,     null], 'power' => -5,  'expected' => '3.23996308063963415E-6-6.05578512975614639E-6i'],
            [ 'complex' => [-9.8765,  -4.321,     null], 'power' => -5,  'expected' => '3.23996308063963415E-6+6.05578512975614639E-6i'],
            [ 'complex' => [-0.98765, 0.4321,     null], 'power' => -5,  'expected' => '-0.323996308063963415-0.605578512975614639i'],
            [ 'complex' => [-0.98765, -0.4321,    null], 'power' => -5,  'expected' => '-0.323996308063963415+0.605578512975614639i'],
            [ 'complex' => [0,        1,          null], 'power' => -5,  'expected' => '-1.0i'],
            [ 'complex' => [0,        -1,         null], 'power' => -5,  'expected' => '1.0i'],
            [ 'complex' => [0,        0.123,      null], 'power' => -5,  'expected' => '-35520.1215120851379i'],
            [ 'complex' => [0,        -0.123,     null], 'power' => -5,  'expected' => '35520.1215120851379i'],
            [ 'complex' => [-1,       null,       null], 'power' => -5,  'expected' => -1.0],
            [ 'complex' => [12,       null,       null], 'power' => 0.25, 'expected' => 1.86120971820419920],
            [ 'complex' => [12.345,   null,       null], 'power' => 0.25, 'expected' => 1.87444530945882037],
            [ 'complex' => [0.12345,  null,       null], 'power' => 0.25, 'expected' => 0.592751652730903220],
            [ 'complex' => [12.345,   6.789,      null], 'power' => 0.25, 'expected' => '1.92210516404477662+0.242887548500393669i'],
            [ 'complex' => [12.345,   -6.789,     null], 'power' => 0.25, 'expected' => '1.92210516404477662-0.242887548500393669i'],
            [ 'complex' => [0.12345,  0.6789,     null], 'power' => 0.25, 'expected' => '0.856867792610750886+0.310579536958859462i'],
            [ 'complex' => [0.12345,  -0.6789,    null], 'power' => 0.25, 'expected' => '0.856867792610750886-0.310579536958859462i'],
            [ 'complex' => [-9.8765,  null,       null], 'power' => 0.25, 'expected' => '1.25353299330667078+1.25353299330667078i'],
            [ 'complex' => [-0.98765, null,       null], 'power' => 0.25, 'expected' => '0.704913404625898229+0.704913404625898229i'],
            [ 'complex' => [-9.8765,  +4.321,     null], 'power' => 0.25, 'expected' => '1.40634392007166601+1.14260385167722940i'],
            [ 'complex' => [-9.8765,  -4.321,     null], 'power' => 0.25, 'expected' => '1.40634392007166601-1.14260385167722940i'],
            [ 'complex' => [-0.98765, 0.4321,     null], 'power' => 0.25, 'expected' => '0.790845303686491030+0.642533364119770246i'],
            [ 'complex' => [-0.98765, -0.4321,    null], 'power' => 0.25, 'expected' => '0.790845303686491030-0.642533364119770246i'],
            [ 'complex' => [0,        1,          null], 'power' => 0.25, 'expected' => '0.923879532511286756+0.382683432365089772i'],
            [ 'complex' => [0,        -1,         null], 'power' => 0.25, 'expected' => '0.923879532511286756-0.382683432365089772i'],
            [ 'complex' => [0,        0.123,      null], 'power' => 0.25, 'expected' => '0.547131379874956782+0.226629237944112972i'],
            [ 'complex' => [0,        -0.123,     null], 'power' => 0.25, 'expected' => '0.547131379874956782-0.226629237944112972i'],
            [ 'complex' => [-1,       null,       null], 'power' => 0.25, 'expected' => '0.707106781186547524+0.707106781186547524i'],
            [ 'complex' => [12,       null,       null], 'power' => 2.5,  'expected' => 498.830632579836661],
            [ 'complex' => [12.345,   null,       null], 'power' => 2.5,  'expected' => 535.460865539803446],
            [ 'complex' => [0.12345,  null,       null], 'power' => 2.5,  'expected' => 0.00535460865539803446],
            [ 'complex' => [12.345,   6.789,      null], 'power' => 2.5,  'expected' => '229.974926965461021+708.644378852355997i'],
            [ 'complex' => [12.345,   -6.789,     null], 'power' => 2.5,  'expected' => '229.974926965461021-708.644378852355997i'],
            [ 'complex' => [0.12345,  0.6789,     null], 'power' => 2.5,  'expected' => '-0.373444904006950202-0.130303840541623798i'],
            [ 'complex' => [0.12345,  -0.6789,    null], 'power' => 2.5,  'expected' => '-0.373444904006950202+0.130303840541623798i'],
            [ 'complex' => [-9.8765,  null,       null], 'power' => 2.5,  'expected' => '306.554482025547228i'],
            [ 'complex' => [-0.98765, null,       null], 'power' => 2.5,  'expected' => '0.969410390133876988i'],
            [ 'complex' => [-9.8765,  +4.321,     null], 'power' => 2.5,  'expected' => '327.329471778753810+196.105804655144990i'],
            [ 'complex' => [-9.8765,  -4.321,     null], 'power' => 2.5,  'expected' => '327.329471778753810-196.105804655144990i'],
            [ 'complex' => [-0.98765, 0.4321,     null], 'power' => 2.5,  'expected' => '1.03510667612066915+0.620141005090309172i'],
            [ 'complex' => [-0.98765, -0.4321,    null], 'power' => 2.5,  'expected' => '1.03510667612066915-0.620141005090309172i'],
            [ 'complex' => [0,        1,          null], 'power' => 2.5,  'expected' => '-0.707106781186547524-0.707106781186547524i'],
            [ 'complex' => [0,        -1,         null], 'power' => 2.5,  'expected' => '-0.707106781186547524+0.707106781186547524i'],
            [ 'complex' => [0,        0.123,      null], 'power' => 2.5,  'expected' => '-0.00375186998995167742-0.00375186998995167742i'],
            [ 'complex' => [0,        -0.123,     null], 'power' => 2.5,  'expected' => '-0.00375186998995167742+0.00375186998995167742i'],
            [ 'complex' => [-1,       null,       null], 'power' => 3.5,  'expected' => '-1i'],
            // phpcs:enable
        ];
    }
}
