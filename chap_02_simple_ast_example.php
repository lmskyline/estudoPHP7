<?php
// simple AST example

function test() 
{
    return [
        1 => function () { return [
            1 => function ($a) { return 'Level 1/1:' . ++$a; },
            2 => function ($a) { return 'Level 1/2:' . ++$a; },
        ];},
        2 => function () { return [
            1 => function ($a) { return 'Level 2/1:' . ++$a; },
            2 => function ($a) { return 'Level 2/2:' . ++$a; },
        ];}
    ];
}

$a = 't';
$t = 'test';

// outputs: Level 1/2:101
// NOTE: PHP 5 returns a parse error!
echo    $$a()[1]()[2](100) . '<br>';
echo    $t()[1]()[2](100) . '<br>';
echo    test()[1]()[2](100) . '<br>';
echo    [1 => function () { return [
            1 => function ($a) { return 'Level 1/1:' . ++$a; },
            2 => function ($a) { return 'Level 1/2:' . ++$a; },
        ];},
        2 => function () { return [
            1 => function ($a) { return 'Level 2/1:' . ++$a; },
            2 => function ($a) { return 'Level 2/2:' . ++$a; },
        ];}][1]()[2](100) . '<br>';
echo    (function () { return [
            1 => function ($a) { return 'Level 1/1:' . ++$a; },
            2 => function ($a) { return 'Level 1/2:' . ++$a; },
        ];})()[2](100) . '<br>';
echo    [
            1 => function ($a) { return 'Level 1/1:' . ++$a; },
            2 => function ($a) { return 'Level 1/2:' . ++$a; },
        ][2](100) . '<br>';
echo    (function ($a) { return 'Level 1/2:' . ++$a; })(100) . '<br>';