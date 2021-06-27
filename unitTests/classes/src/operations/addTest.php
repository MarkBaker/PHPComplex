<?php

namespace Complex;

class addTest extends BaseOperationTestAbstract
{
    protected static $functionName = 'add';

    /**
     * @dataProvider dataProvider
     */
    public function testAddStatic()
    {
        $args = func_get_args();
        $complex1 = new Complex($args[0]);
        $complex2 = new Complex($args[1]);
        $result = Operations::add($complex1, $complex2);

        $this->complexNumberAssertions($args[2], $result);
        // Verify that the original complex values remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex1);
        $this->assertEquals(new Complex($args[1]), $complex2);
    }

    public function dataProvider()
    {
        return [
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '22.2215+11.11i'],
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '22.2215+2.468i'],
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '2.4685+11.11i'],
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '2.4685+2.468i'],

            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '22.2215-2.468i'],
            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '22.2215-11.11i'],
            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '2.4685-2.468i'],
            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '2.4685-11.11i'],

            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '-2.4685+11.11i'],
            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '-2.4685+2.468i'],
            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '-22.2215+11.11i'],
            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '-22.2215+2.468i'],

            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '-2.4685-2.468i'],
            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '-2.4685-11.11i'],
            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '-22.2215-2.468i'],
            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '-22.2215-11.11i'],
        ];
    }
}
