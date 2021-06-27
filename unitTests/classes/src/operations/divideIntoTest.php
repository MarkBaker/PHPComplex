<?php

namespace Complex;

class divideIntoTest extends BaseOperationTestAbstract
{
    protected static $functionName = 'divideinto';

    /**
     * @dataProvider dataProvider
     */
    public function testDivideIntoStatic()
    {
        $args = func_get_args();
        $complex1 = new Complex($args[0]);
        $complex2 = new Complex($args[1]);
        $result = Operations::divideinto($complex1, $complex2);

        $this->complexNumberAssertions($args[2], $result);
        // Verify that the original complex values remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex1);
        $this->assertEquals(new Complex($args[1]), $complex2);
    }

    public function dataProvider()
    {
        return [
            // @codingStandardsIgnoreStart Generic.Files.LineLength.TooLong
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '0.762058579649-0.06906567008823727i'],
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '0.466473551710-0.606552364728i'],
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '-0.466473551710+0.606552364728i'],
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '-0.762058579649+0.06906567008823727i'],

            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '0.466473551710+0.606552364728i'],
            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '0.762058579649-0.06906567008823727i'],
            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '-0.762058579649-0.06906567008823727i'],
            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '-0.466473551710-0.606552364728i'],

            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '-0.466473551710-0.606552364728i'],
            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '-0.762058579649-0.06906567008823727i'],
            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '0.762058579649+0.06906567008823727i'],
            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '0.466473551710+0.606552364728i'],

            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '-0.762058579649+0.06906567008823727i'],
            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '-0.466473551710+0.606552364728i'],
            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '0.466473551710-0.606552364728i'],
            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '0.762058579649-0.06906567008823727i'],
            // @codingStandardsIgnoreEnd Generic.Files.LineLength.TooLong
        ];
    }
}
