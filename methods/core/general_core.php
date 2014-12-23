<?php
function correctNum($arg) {
    return (float) number_format($arg, 4); // using (float) for deletion zeros (2.500=2.5)
}

function getCalc($coef1, $coef2, $coef3, $coef4, $x) {
    $calc[0] = correctNum($coef1 * $x);       //2 row, 3 col
    $calc[1] = correctNum($calc[0] + $coef2); //3 row, 3 col
    $calc[2] = correctNum($calc[1] * $x);     //2 row, 4 col
    $calc[3] = correctNum($calc[2] + $coef3); //3 row, 4 col
    $calc[4] = correctNum($calc[3] * $x);     //2 row, 5 col
    $calc[5] = correctNum($calc[4] + $coef4); //3 row, 5 col
    
    return $calc;
}

function getCalc_L($coef1_L, $coef2_L, $coef3_L, $x) {
    $calc_L[0] = correctNum($coef1_L * $x);
    $calc_L[1] = correctNum($calc_L[0] + $coef2_L);
    $calc_L[2] = correctNum($calc_L[1] * $x);
    $calc_L[3] = correctNum($calc_L[2] + $coef3_L);
    
    return $calc_L;
}

//this func counts up square equation
function countUpSquare($coef1, $coef2, $coef3, $firstSolution) {
    $calcSquare = "<br />Урав. 2-го порядка: ({$coef1} * x<sup>2</sup>) + ({$coef2} * x) + ({$coef3}) = 0<br />";
    $d = correctNum(pow($coef2, 2)-(4*$coef1*$coef3));
    $calcSquare .= "<br />D = {$coef2}<sup>2</sup> - 4*{$coef1}*{$coef3} = {$d}<br /><br />";  
    
    if ($d < 0) {
        $d = abs($d);
        $pow12 = correctNum(pow($d, 1/2));
        $part1 = correctNum((-$coef2) / (2*$coef1));
        $part2 = correctNum(($pow12) / (2*$coef1));
        $calcSquare .= "x<sub>2, 3</sub> = ( -({$coef2}) &#177; √<span class='radical'>-{$d}</span> ) / (2*{$coef1}) = ( -({$coef2}) &#177; {$pow12}i ) / (2*{$coef1}) = <span class='colorBlue''>{$part1} &#177; {$part2}i</span>";
    } elseif ($d > 0) {
        $pow12 = correctNum(pow($d, 1/2));
        $secondSolution = correctNum((-$coef2 + $pow12) / (2*$coef1));
        $thirdSolution = correctNum((-$coef2 - $pow12) / (2*$coef1));
        $calcSquare .= "x<sub>2</sub> = ( -({$coef2}) + √<span class='radical'>{$d}</span> ) / (2*{$coef1}) = ( -({$coef2}) + {$pow12} ) / (2*{$coef1}) = <span class='colorBlue''>{$secondSolution}</span><br /><br />
                        x<sub>3</sub> = ( -({$coef2}) - √<span class='radical'>{$d}</span> ) / (2*{$coef1}) = ( -({$coef2}) - {$pow12} ) / (2*{$coef1}) = <span class='colorBlue''>{$thirdSolution}</span>";
    } else {
        $secondSolution = (-$coef2)/(2*$coef1);
        $calcSquare .= "x<sub>2</sub> = -({$coef2}) / (2 * {$coef1}) = {$secondSolution}<br /><br />
                        <span style='color: red;'>По идее такого быть не должно!<br />Лучше перепроверить введённые данные</span>";
    }
    
    $calcSquare .= "<br /><br />x<sub>1</sub> = <span class='colorBlue'>{$firstSolution}</span><br />";
    
    return $calcSquare;
}
