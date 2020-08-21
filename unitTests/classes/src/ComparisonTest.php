<?php

namespace Complex;

use Complex\Complex as Complex;

class ComparisonTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider providerCompare
     */
    public function testCompare($arguments1, $arguments2, $expectedResult)
    {
        $complex1 = new Complex(...$arguments1);
        $complex2 = new Complex(...$arguments2);

        if ($expectedResult) {
            $this->assertEquals($complex1, $complex2);
        } else {
            $this->assertNotEquals($complex1, $complex2);
        }
    }

    public function providerCompare()
    {
        return [
            'Matched real numbers only' => [[-2], [-2], true],
            'Mis-matched real numbers only' => [[-2], [-1], false],
            'Matched real numbers, one with an irrelevant suffix' => [[-2], [-2, 0, 'i'], true],
            'Mis-matched real numbers, one with a suffix' => [[-1], [-2, 0, 'i'], false],
            'Matched real numbers, both with irrelevant suffixes' => [[-2, 0, 'j'], [-2, 0, 'i'], true],
            'Mis-matched complex numbers (matched values but mis-matched suffixes)' => [[-2, 1, 'j'], [-2, 1, 'i'], false],
            'Matched real numbers, one with an empty suffix, the other with an irrelevant suffix'
                => [[-2, 0, ''], [-2, 0, 'i'], true],
            'Matched complex numbers with default suffix' => [[-2, 1], [-2, 1], true],
            'Mis-matched complex numbers with default suffix' => [[-1, 2], [-2, 1], false],
            'Matched complex numbers with default suffix, and zero value real part' =>[[0, -2], [0, -2], true],
            'Matched complex numbers, one with default suffix, and zero value real part' => [[0, -2], [0, -2, 'i'], true],
            'Mis-matched complex numbers, one with default suffix, and zero value real part' => [[0, -2], [0, -2, 'j'], false],
        ];
    }
}
