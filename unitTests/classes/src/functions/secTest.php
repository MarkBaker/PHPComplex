<?php

namespace Complex;

class secTest extends BaseFunctionTestAbstract
{
    protected static $functionName = 'sec';

    /**
     * @dataProvider dataProvider
     */
    public function testSecStatic()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = Functions::sec($complex);

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /**
     * @dataProvider dataProviderInvoker
     */
    public function testSecInvoker()
    {
        $args = func_get_args();
        $complex = new Complex($args[0]);
        $result = $complex->sec();

        $this->complexNumberAssertions($args[1], $result);
        // Verify that the original complex value remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex);
    }

    /*
     * Results derived from Wolfram Alpha using
     *  N[Sec[<VALUE>], 18]
     */
    public function dataProvider()
    {
        $expectedResults = [
            1.18503917609398493,
            1.02501295645097987,
            1.00766863937283452,
            '0.00219722715877619811-0.00049450452915277163i',
            '0.00219722715877619811+0.00049450452915277163i',
            '0.00223504616546252215+0.00027732598978879297i',
            '0.00223504616546252215-0.00027732598978879297i',
            '0.808656714283989823+0.059280609855590377i',
            '0.808656714283989823-0.059280609855590377i',
            -1.11148563248354830,
            1.81602568471788017,
            '-0.0239067997283027954+0.0115950232737292425i',
            '-0.0239067997283027954-0.0115950232737292425i',
            '1.201301356245620536-0.741304132097185254i',
            '1.201301356245620536+0.741304132097185254i',
            0.648054273663885400,
            0.648054273663885400,
            0.992482893127170164,
            0.992482893127170164,
            1.85081571768092562,
        ];

        return $this->formatOneArgumentTestResultArray($expectedResults);
    }
}
