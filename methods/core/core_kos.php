<?php

function countUpKos(array $param) {
    
    foreach ($param as $key => $value)
        $$key = $value;
    unset($param);
    
    /*count coefs f'(x[n])*/
    $coef1_L = $coef1*3;
    $coef2_L = $coef2*2;
    $coef3_L = $coef3;
    /*//count coefs f'(x[n])*/
    
    $n=0;
    $tabCalc="<tr><th></th><th>$coef1</th><th>$coef2</th><th>$coef3</th><th>$coef4</th></tr>"; // table for calcs f(x)
    $tabCalc_L="<tr><th></th><th>$coef1_L</th><th>$coef2_L</th><th>$coef3_L</th></tr>";        // table for calcs f'(x)
    
    do {
        $param=array('id' => $n, 'x[n]' => $x);
        
        $calc = getCalc($coef1, $coef2, $coef3, $coef4, $x);
        $calc_L = getCalc_L($coef1_L, $coef2_L, $coef3_L, $x);
        
        $tabCalc .= "<tr style='border-top: 2px solid black;'><td rowspan='2'>x[$n] = $x</td><td>:</td><td>$calc[0]</td><td>$calc[2]</td><td>$calc[4]</td></tr>
                    <tr><td>$coef1</td><td>$calc[1]</td><td>$calc[3]</td><td>$calc[5]</td></tr>";
        
        $tabCalc_L .= "<tr style='border-top: 2px solid black;'><td rowspan='2'>x[$n] = $x</td><td>:</td><td>$calc_L[0]</td><td>$calc_L[2]</td></tr>
                    <tr><td>$coef1_L</td><td>$calc_L[1]</td><td>$calc_L[3]</td></tr>";
        
        $param['f(x[n])']=$calc[5];
        $param['f\'(x[n])']=$calc_L[3];
        
        if (empty($param['f\'(x[n])'])) //early exit (division by zero)
            return false;
            
        $param['h']=correctNum($param['f(x[n])']/$param['f\'(x[n])']);
        
        $params[$n]=$param;
        
        if (empty($param['h'])) { // keeping coefs square equation for counting two other solutions
            $coef2 = $calc[1];
            $coef3 = $calc[3];
        }
        
        $x=correctNum($x-$param['h']);
        $n++;
    } while (!empty($param['h']) && $n<56); //if there is closing, 56 step will be last 
    
    $lastX = &$params[count($params)-1]['x[n]'];
    $lastX = "<span class='colGreen'>$lastX</span>";
    unset($lastX);
    
    return [$params, $tabCalc, $tabCalc_L, countUpSquare($coef1, $coef2, $coef3, $param['x[n]'])];
}