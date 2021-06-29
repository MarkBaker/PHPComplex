<?php

namespace Complex;

class expTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'exp';

    /**
     * @dataProvider dataProvider
     */
    public function testExpStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::exp($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testExpInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->exp();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[Exp[<VALUE>], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            162754.791419003921,
            229808.124861245955,
            1.13139343345614055,
            '201031.558264856609+111346.696555603181i',
            '201031.558264856609-111346.696555603181i',
            '0.989720381190360417+0.548183060960553592i',
            '0.989720381190360417-0.548183060960553592i',
            '0.880522689156788117+0.710444153433450838i',
            '0.880522689156788117-0.710444153433450838i',
            0.0000513677507359735403,
            0.372450923066270627,
            '-0.0000195953960306484277-0.0000474833262322171154i',
            '-0.0000195953960306484277+0.0000474833262322171154i',
            '0.338218332028097927+0.155974517063039339i',
            '0.338218332028097927-0.155974517063039339i',
            '0.540302305868139717+0.841470984807896507i',
            '0.540302305868139717-0.841470984807896507i',
            '0.992445032135193570+0.122690090024315336i',
            '0.992445032135193570-0.122690090024315336i',
            0.367879441171442322,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
