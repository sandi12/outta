<?php

function countUpKombo(array $param) {
    $pattern = '<span>x<sub class=\'index\' >n</sub></span>';
    $pattern_line = '<span>x<sub class=\'index\' >n</sub><sup class=\'line\' >—</sup></span>';
    $patOnlyLine = '<sup class=\'line\' >—</sup>';
    
    //transformation array's items on single vars | begin
    foreach ($param as $key => $value)
        $$key = $value;
    unset($param);
    //transformation array's items on single vars | end
    
    if (empty($end)) { //$end = 0 => fixed A ; $end = 1 => fixed B
        $forDiff = 1;
        $x = $b;
        $x_line = $a;
        $forTable = "{$pattern} - {$pattern_line}";
        $forTableF = "f({$pattern}) - f({$pattern_line})";
    } else {
        $forDiff = -1;
        $x = $a;
        $x_line = $b;
        $forTable = "{$pattern_line} - {$pattern}";
        $forTableF = "f({$pattern_line}) - f({$pattern})";
    }
    
    /*count coefs f'(x[n])*/
    $coef1_L = $coef1*3;
    $coef2_L = $coef2*2;
    $coef3_L = $coef3;
    /*//count coefs f'(x[n])*/
    
    $n = 0;
    
    $mainTable = "<tr><th rowspan='2'>n</th><th>{$pattern}</th><th rowspan='2'>{$forTable}</th><th>f({$pattern})</th><th rowspan='2'>{$forTableF}</th><th rowspan='2'>f '({$pattern_line})</th><th>h</th></tr>
                  <tr><th>{$pattern_line}</th><th>f({$pattern_line})</th><th>h<sup class='lineH' >—</sup></th></tr>";
    
    //table for calcs f(x)
    $tabCalc = "<tr><th class='fontNorm' ><span class='colorBlack'>result:</span> f({$pattern})</th><th>{$coef1}</th><th>{$coef2}</th><th>{$coef3}</th><th>{$coef4}</th></tr>\n";           
    //table for calcs f(x_line)
    $tabCalc_line = "<tr><th class='fontNorm'><span class='colorBlack'>result:</span> f({$pattern_line})</th><th>{$coef1}</th><th>{$coef2}</th><th>{$coef3}</th><th>{$coef4}</th></tr>\n"; 
    //table for calcs f'(x_line)
    $tabCalc_deriv_line="<tr><th class='fontNorm'><span class='colorBlack'>result:</span> f '({$pattern_line})</th><th>{$coef1_L}</th><th>{$coef2_L}</th><th>{$coef3_L}</th></tr>\n"; 
    //this var have list of calcs h
    $listOfH = ''; 
    
    do {
        $param = ['id' => $n, 'x[n]' => $x, 'x[n]line' => $x_line, 'x[n]-x[n]line' => correctNum(($x - $x_line)*$forDiff)];
        
        $patChanging = "<sub class=\'index\' >{$n}</sub>";
        
        $calc = getCalc($coef1, $coef2, $coef3, $coef4, $x);
        $calc_line = getCalc($coef1, $coef2, $coef3, $coef4, $x_line);
        $calc_deriv_line = getCalc_L($coef1_L, $coef2_L, $coef3_L, $x_line);
        
        $tabCalc .= "<tr class='separate' ><td rowspan='2'>x{$patChanging} = {$x}</td><td>:</td><td>{$calc[0]}</td><td>{$calc[2]}</td><td>{$calc[4]}</td></tr>
                    <tr><td>{$coef1}</td><td>{$calc[1]}</td><td>{$calc[3]}</td><td class='colGreen'>{$calc[5]}</td></tr>";
                    
        $tabCalc_line .= "<tr class='separate' ><td rowspan='2'>x{$patChanging}{$patOnlyLine} = {$x_line}</td><td>:</td><td>{$calc_line[0]}</td><td>{$calc_line[2]}</td><td>{$calc_line[4]}</td></tr>
                    <tr><td>{$coef1}</td><td>{$calc_line[1]}</td><td>{$calc_line[3]}</td><td class='colGreen'>{$calc_line[5]}</td></tr>";
                    
        $tabCalc_deriv_line .= "<tr class='separate' ><td rowspan='2'>x{$patChanging}{$patOnlyLine} = {$x_line}</td><td>:</td><td>{$calc_deriv_line[0]}</td><td>{$calc_deriv_line[2]}</td></tr>
                    <tr><td>{$coef1_L}</td><td>{$calc_deriv_line[1]}</td><td class='colGreen'>{$calc_deriv_line[3]}</td></tr>";
        
        if (abs($param['x[n]-x[n]line']) <= 0.0001) {
            $mainTable .= "<tr class='separate'><td rowspan='2'>{$n}</td><td>{$param['x[n]']}</td><td rowspan='2'>{$param['x[n]-x[n]line']}</td></tr>
                           <tr><td>{$param['x[n]line']}</td></tr>";
            break 1;
        }
        
        $param['f(x[n])'] = $calc[5];
        $param['f(x[n])line'] = $calc_line[5];
        $param['f\'(x[n])line'] = $calc_deriv_line[3];
        
        $param['f(x[n])-f(x[n])line'] = ($param['f(x[n])'] - $param['f(x[n])line'])*$forDiff;
        
        //early exit (division by zero)
        if (empty($param['f(x[n])-f(x[n])line']) || empty($param['f\'(x[n])line'])) {
            return false;
        }
        
        $param['h'] = correctNum($param['f(x[n])']*$param['x[n]-x[n]line']/$param['f(x[n])-f(x[n])line']);
        
        $param['h_line'] = correctNum($param['f(x[n])line']/$param['f\'(x[n])line']);
        
        $listOfH .= "h{$patChanging} = {$param['f(x[n])']} * {$param['x[n]-x[n]line']} / {$param['f(x[n])-f(x[n])line']} = {$param['h']}<br/>
                     h{$patChanging}<sup class='lineH' style='right: 19px;' >—</sup> = {$param['f(x[n])line']} / {$param['f\'(x[n])line']} = {$param['h_line']}";

        
        $mainTable .= "<tr class='separate'><td rowspan='2'>{$n}</td><td>{$param['x[n]']}</td><td rowspan='2'>{$param['x[n]-x[n]line']}</td>
                           <td>{$param['f(x[n])']}</td><td rowspan='2'>{$param['f(x[n])-f(x[n])line']}</td>
                           <td rowspan='2'>{$param['f\'(x[n])line']}</td><td>{$param['h']}</td></tr>
                       <tr><td>{$param['x[n]line']}</td><td>{$param['f(x[n])line']}</td><td>{$param['h_line']}</td></tr>";
        
        if (empty($param['h']) && empty($param['h_line'])) {
            $listOfH .= '<hr />';
            break 1;
        }
        
        $x = correctNum($x - $param['h']);
        $x_line = correctNum($x_line - $param['h_line']);
        $n++;
        
        $listOfH .= "<br />x<sub class=\'index\' >{$n}</sub> = {$param['x[n]']} - ({$param['h']}) = {$x}<br />
                     x<sub class=\'index\' >{$n}</sub>{$patOnlyLine} = {$param['x[n]line']} - ({$param['h_line']}) = {$x_line}<hr />";

        
    } while ($n<30); //if there is closing, 30 step will be last
    
    //keeping coefs square equation for counting two other solutions |begin
    //redefine vars $coef2 and $coef3
    if (abs($calc[5]) <= abs($calc_line[5])) {
        $coef2 = $calc[1];
        $coef3 = $calc[3];
        $firstSolution = $param['x[n]'];
    } else {
        $coef2 = $calc_line[1];
        $coef3 = $calc_line[3];
        $firstSolution = $param['x[n]line'];
    }
    //keeping coefs square equation for counting two other solutions |end
    
    return [$mainTable, $tabCalc, $tabCalc_line, $tabCalc_deriv_line, $listOfH, countUpSquare($coef1, $coef2, $coef3, $firstSolution)];   
}