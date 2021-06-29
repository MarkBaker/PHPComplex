<?php

namespace Complex;

class conjugateTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'conjugate';

    /**
     * @dataProvider dataProvider
     */
    public function testConjugateStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::conjugate($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testConjugateInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->conjugate();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[Conjugate[<VALUE>], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            12,
            12.345,
            0.12345,
            '12.345-6.789i',
            '12.345+6.789i',
            '0.12345-6.789i',
            '0.12345+6.789i',
            '0.12345-0.6789i',
            '0.12345+0.6789i',
            -9.8765,
            -0.98765,
            '-9.8765-4.321i',
            '-9.8765+4.321i',
            '-0.98765-0.4321i',
            '-0.98765+0.4321i',
            '-i',
            'i',
            '-0.123i',
            '0.123i',
            -1.0,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
