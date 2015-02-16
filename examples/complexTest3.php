<?php
namespace Complex;
include('../classes/Bootstrap.php');

$complexFunction1 =  __NAMESPACE__ . '\\' . 'cos';
$complexFunction2 =  __NAMESPACE__ . '\\' . 'haversine';
$complexFunction3 =  __NAMESPACE__ . '\\' . 'inversehaversine';
$complexFunction4 =  __NAMESPACE__ . '\\' . 'gudermannian';
$complexFunction5 =  __NAMESPACE__ . '\\' . 'inversegudermannian';
$complexFunction6 =  __NAMESPACE__ . '\\' . 'coth';
$complexFunction7 =  __NAMESPACE__ . '\\' . 'acoth';
$complexFunction8 =  __NAMESPACE__ . '\\' . 'tanh';
$complexFunction9 =  __NAMESPACE__ . '\\' . 'atanh';


echo $complexFunction1( 9 ) . '<br/>' . PHP_EOL;

echo "<h3>Haversine</h3><br/>" . PHP_EOL;
for ( $i = -10; $i <= 10; $i++ ) {
    echo ( $i ) . ': ' . $complexFunction2( $i ) . '<br/>' . PHP_EOL;
}
unset($i);

echo "<h3>Inverse haversine</h3><br/>" . PHP_EOL;
for ( $i = -10; $i <= 10; $i++ ) {
    echo ( $i ) . ': ' . $complexFunction3( $i ) . '<br/>' . PHP_EOL;
}
unset($i);

echo "<h3>Gudermannian</h3><br/>" . PHP_EOL;
for ( $i = -10; $i <= 10; $i++ ) {
    echo ( $i ) . ': ' . $complexFunction4( $i ) . '<br/>' . PHP_EOL;
}
unset($i);

echo "<h3>Inverse Gudermannian</h3><br/>" . PHP_EOL;
for ( $i = -10; $i <= 10; $i++ ) {
    echo ( $i ) . ': ' . $complexFunction5( $i ) . '<br/>' . PHP_EOL;
}
unset($i);

echo "<h3>Coth</h3><br/>" . PHP_EOL;
for ( $i = -10; $i <= 10; $i++ ) {
    echo ( $i ) . ': ' . $complexFunction6( $i ) . '<br/>' . PHP_EOL;
}
unset($i);

echo "<h3>ArcCoth</h3><br/>" . PHP_EOL;
for ( $i = -10; $i <= 10; $i++ ) {
    echo ( $i ) . ': ' . $complexFunction7( $i ) . '<br/>' . PHP_EOL;
}
unset($i);

echo "<h3>Tanh</h3><br/>" . PHP_EOL;
for ( $i = -10; $i <= 10; $i++ ) {
    echo ( $i ) . ': ' . $complexFunction8( $i ) . '<br/>' . PHP_EOL;
}
unset($i);

echo "<h3>ArcTanh</h3><br/>" . PHP_EOL;
for ( $i = -10; $i <= 10; $i++ ) {
    echo ( $i ) . ': ' . $complexFunction9( $i ) . '<br/>' . PHP_EOL;
}
unset($i);
