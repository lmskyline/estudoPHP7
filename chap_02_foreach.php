<?php

$a = [1,2,3];
foreach ($a as $v) {
    printf("%2d\n", $v);
    unset($a[1]);
}
echo '<br>';

$a = [1,2,3];
$b = &$a;
foreach ($a as $v) {
    printf("%2d\n", $v);
    unset($a[1]);
}

echo '<br>';

$a = [1,2,3];
foreach ($a as $v) {
    printf("%2d - %2d\n", $v, current($a));
}

echo '<br>';
$a = [1];
foreach($a as &$v) {
    printf("%2d -\n", $v);
    $a[1]=2;
}

echo '<br>';

$a = [1, 2, 3, 4];
foreach ($a as &$v) {
    echo "$v\n";
    array_pop($a);
}

echo '<br>';

$a = [0, 1, 2, 3];
foreach ($a as &$x) {
    foreach ($a as &$y) {
        echo "$x - $y\n";
        if ($x == 0 && $y == 1) {
            unset($a[1]);
        }
    }
}

