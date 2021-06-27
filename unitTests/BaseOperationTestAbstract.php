<?php

namespace Complex;

abstract class BaseOperationTestAbstract extends BaseTestAbstract
{
    public function testInvalidArgument()
    {
        $this->expectException(\Exception::class);

        $invalidComplex = '*** INVALID ***';
        call_user_func([ __NAMESPACE__ . '\\Operations', static::$functionName], $invalidComplex, 1);
    }
}
