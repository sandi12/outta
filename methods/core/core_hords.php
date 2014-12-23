<?php

function countUpHords(array $param) {
    foreach ($param as $key => $value)
        $$key = $value;
    unset($param);
    
    if (empty($end)){ //$end = 0 => A ; $end = 1 => B
        $forDiff = 1;
        $x = $b;
    } else {
        $forDiff = -1;
        $x = $a;
        $a = $b;
    }
    
    $f_a = ($coef1*pow($a, 3)) + ($coef2*pow($a, 2)) + ($coef3*$a) + $coef4; //count f(a) or f(b)
    
    $n = 0;
    $tabCalc = "<tr><th></th><th>$coef1</th><th>$coef2</th><th>$coef3</th><th>$coef4</th></tr>"; //table for calcs
    $listOfH = ''; //this var have list of calcs h
    
    do {
        $param = ['id' => $n, 'x[n]' => $x];
        
        $calc = getCalc($coef1, $coef2, $coef3, $coef4, $x);
        
        $tabCalc .= "<tr style='border-top: 2px solid black;'><td rowspan='2'>x[$n] = $x</td><td>:</td><td>$calc[0]</td><td>$calc[2]</td><td>$calc[4]</td></tr>
                    <tr><td>$coef1</td><td>$calc[1]</td><td>$calc[3]</td><td>$calc[5]</td></tr>";
        
        $param['f(x[n])'] = $calc[5];
        $param['a/b'] = correctNum(($x-$a)*$forDiff);
        $param['f(a/b)'] = correctNum(($param['f(x[n])']-$f_a)*$forDiff);
        
        if (empty($param['f(a/b)'])) //early exit (division by zero)
            return false;
            
        $param['h'] = correctNum($param['f(x[n])']*$param['a/b']/$param['f(a/b)']);
        
        $listOfH .= "h[$n] = {$param['f(x[n])']} * {$param['a/b']} / {$param['f(a/b)']} = {$param['h']}<br/>";
        $params[$n] = $param;
        $x = correctNum($x-$param['h']);
        $n++;
    } while (!empty($param['h']) && $n<56); //if there is closing, 56 step will be last
    
    $lastX = &$params[count($params)-1]['x[n]'];
    $lastX = "<span class='colGreen'>$lastX</span>";
    unset($lastX);
    
    return [$params, $tabCalc, $listOfH];
}