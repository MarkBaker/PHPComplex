<?php

include './Complex.php';

$x1 = new Complex(123);
var_dump($x1);
$x1->add(456);
var_dump($x1);


$x2 = new Complex(123.456);
var_dump($x2);
$x2->add(789.012);
var_dump($x2);


$x3 = new Complex(123.456, 78.90);
var_dump($x3);
$x3->add(new Complex(987.654, 32.1));
var_dump($x3);


$x3 = new Complex(123.456, 78.90);
var_dump($x3);
$x3->subtract(new Complex(987.654, 32.1));
var_dump($x3);
