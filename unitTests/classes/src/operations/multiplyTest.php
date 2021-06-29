<?php

namespace Complex;

class multiplyTest extends BaseOperationTestAbstract
{
    protected static $functionName = 'multiply';

    /**
     * @dataProvider dataProvider
     */
    public function testMultiplyStatic()
    {
        $args = func_get_args();
        $complex1 = new Complex($args[0]);
        $complex2 = new Complex($args[1]);
        $result = Operations::multiply($complex1, $complex2);

        $this->complexNumberAssertions($args[2], $result);
        // Verify that the original complex values remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex1);
        $this->assertEquals(new Complex($args[1]), $complex2);
    }

    public function dataProvider()
    {
        return [
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '92.5901235+120.3943035i'],
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '151.2606615+13.7088135i'],
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '-151.2606615-13.7088135i'],
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '-92.5901235-120.3943035i'],

            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '151.2606615-13.7088135i'],
            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '92.5901235-120.3943035i'],
            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '-92.5901235+120.3943035i'],
            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '-151.2606615+13.7088135i'],

            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '-151.2606615+13.7088135i'],
            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '-92.5901235+120.3943035i'],
            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '92.5901235-120.3943035i'],
            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '151.2606615-13.7088135i'],

            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '-92.5901235-120.3943035i'],
            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '-151.2606615-13.7088135i'],
            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '151.2606615+13.7088135i'],
            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '92.5901235+120.3943035i'],
        ];
    }
}
