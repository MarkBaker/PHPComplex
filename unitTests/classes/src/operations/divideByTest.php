<?php

namespace Complex;

class divideByTest extends BaseOperationTestAbstract
{
    protected static $functionName = 'divideby';

    /**
     * @dataProvider dataProvider
     */
    public function testDivideByStatic()
    {
        $args = func_get_args();
        $complex1 = new Complex($args[0]);
        $complex2 = new Complex($args[1]);
        $result = Operations::divideby($complex1, $complex2);

        $this->complexNumberAssertions($args[2], $result);
        // Verify that the original complex values remains unchanged
        $this->assertEquals(new Complex($args[0]), $complex1);
        $this->assertEquals(new Complex($args[1]), $complex2);
    }

    public function dataProvider()
    {
        return [
            // @codingStandardsIgnoreStart Generic.Files.LineLength.TooLong
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '1.3015443641332967+0.11795947983395175i'],
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '0.7967051857421034+1.0359502969262013i'],
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '-0.7967051857421034-1.0359502969262013i'],
            [ 'complex1' => [12.345, 6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '-1.3015443641332967-0.11795947983395175i'],

            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '0.7967051857421034-1.0359502969262013i'],
            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '1.3015443641332967-0.11795947983395175i'],
            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '-1.3015443641332967+0.11795947983395175i'],
            [ 'complex1' => [12.345, -6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '-0.7967051857421034+1.0359502969262013i'],

            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '-0.7967051857421034+1.0359502969262013i'],
            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '-1.3015443641332967+0.11795947983395175i'],
            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '1.3015443641332967-0.11795947983395175i'],
            [ 'complex1' => [-12.345, 6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '0.7967051857421034-1.0359502969262013i'],

            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [9.8765, 4.321, 'i'], 'expected' => '-1.3015443641332967-0.11795947983395175i'],
            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [9.8765, -4.321, 'i'], 'expected' => '-0.7967051857421034-1.0359502969262013i'],
            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [-9.8765, 4.321, 'i'], 'expected' => '0.7967051857421034+1.0359502969262013i'],
            [ 'complex1' => [-12.345, -6.789, 'i'], 'complex2' => [-9.8765, -4.321, 'i'], 'expected' => '1.3015443641332967+0.11795947983395175i'],
            // @codingStandardsIgnoreEnd Generic.Files.LineLength.TooLong
        ];
    }
}
