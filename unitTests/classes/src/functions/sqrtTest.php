<?php

namespace Complex;

class sqrtTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'sqrt';

    /**
     * @dataProvider dataProvider
     */
    public function testSqrtStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::sqrt($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testSqrtInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->sqrt();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[Sqrt[<VALUE>], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            3.46410161513775459,
            3.51354521815217286,
            0.351354521815217286,
            '3.63549390043106654+0.93371082250956562i',
            '3.63549390043106654-0.93371082250956562i',
            '1.85924343537131941+1.82574263026620090i',
            '1.85924343537131941-1.82574263026620090i',
            '0.637762765236041240+0.532251204528014058i',
            '0.637762765236041240-0.532251204528014058i',
            '3.14268993061676385i',
            '0.993805816042550638i',
            '0.67225965965490047+3.21378795971347845i',
            '0.67225965965490047-3.21378795971347845i',
            '0.212587170355908969+1.016288986952004839i',
            '0.212587170355908969-1.016288986952004839i',
            '0.707106781186547524+0.707106781186547524i',
            '0.707106781186547524-0.707106781186547524i',
            '0.247991935352744888+0.247991935352744888i',
            '0.247991935352744888-0.247991935352744888i',
            '1.0i',
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
