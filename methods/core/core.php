<?
function correctNum ($arg) {
    return (float) number_format ($arg, 4); // при помощи (float) убираем нули в дробной части (2.500=2.5)
}

function countUpHords (array $param) {
    foreach ($param as $key => $value)
        $$key = $value;
    unset($param);
    
    if (empty($end)){
        $forDiff = 1;
        $x = $b;
    }
    else {
        $forDiff = -1;
        $x = $a;
        $a=$b;
    }
    
    $f_a = ($coef1*pow($a, 3)) + ($coef2*pow($a, 2)) + ($coef3*$a) + $coef4; //считаем f(a) or f(b)
    
    $n = 0;
    $tabCalc="<tr><th></th><th>$coef1</th><th>$coef2</th><th>$coef3</th><th>$coef4</th></tr>"; //Таблица с расчётами
    $listOfH = ''; //перемен., в которую записывается список расчётов h
    
    do{
        $param=['id' => $n, 'x[n]' => $x];
        $calc[0]=correctNum ($coef1*$x);
        $calc[1]=correctNum ($calc[0]+$coef2);
        $calc[2]=correctNum ($calc[1]*$x);
        $calc[3]=correctNum ($calc[2]+$coef3);
        $calc[4]=correctNum ($calc[3]*$x);
        $calc[5]=correctNum ($calc[4]+$coef4);
             
        $tabCalc.= "<tr style='border-top: 2px solid black;'><td rowspan='2'>x[$n] = $x</td><td>:</td><td>$calc[0]</td><td>$calc[2]</td><td>$calc[4]</td></tr>
                    <tr><td>$coef1</td><td>$calc[1]</td><td>$calc[3]</td><td>$calc[5]</td></tr>";
        
        $param['f(x[n])']=$calc[5];
        $param['a/b']=correctNum (($x-$a)*$forDiff);
        $param['f(a/b)']=correctNum (($param['f(x[n])']-$f_a)*$forDiff);
        
        if (empty($param['f(a/b)'])) //экстренный выход (деление на ноль)
            return false;
            
        $param['h']=correctNum($param['f(x[n])']*$param['a/b']/$param['f(a/b)']);
        
        $listOfH.="h[$n] = {$param['f(x[n])']} * {$param['a/b']} / {$param['f(a/b)']} = {$param['h']}<br/>";
        $params[$n]=$param;
        $x=correctNum ($x-$param['h']);
        $n++;
    }while (!empty($param['h']) && $n<56); //если замыкается, 56 последняя итерация
    
    $lastX=$params[count($params)-1]['x[n]'];
    $params[count($params)-1]['x[n]'] = "<span style='color: green;'>$lastX</span>";
    
    return [$params, $tabCalc, $listOfH];
}

function countUpKos (array $param) {
    
    foreach ($param as $key => $value)
        $$key = $value;
        
    /*Коэф. f'()*/
    $coef1_L=$coef1*3;
    $coef2_L=$coef2*2;
    $coef3_L=$coef3;
    /*//Коэф. f'()*/
    
    $n=0;
    $tabCalc="<tr><th></th><th>$coef1</th><th>$coef2</th><th>$coef3</th><th>$coef4</th></tr>"; //Таблица с расчётами f(x)
    $tabCalc_L="<tr><th></th><th>$coef1_L</th><th>$coef2_L</th><th>$coef3_L</th></tr>"; //Таблица с расчётами f'(x)
    
    do{
        $param=array('id' => $n, 'x[n]' => $x);
        $calc[0]=correctNum ($coef1*$x);
        $calc[1]=correctNum ($calc[0]+$coef2);
        $calc[2]=correctNum ($calc[1]*$x);
        $calc[3]=correctNum ($calc[2]+$coef3);
        $calc[4]=correctNum ($calc[3]*$x);
        $calc[5]=correctNum ($calc[4]+$coef4);
        
        $calc_L[0]=correctNum ($coef1_L*$x);
        $calc_L[1]=correctNum ($calc_L[0]+$coef2_L);
        $calc_L[2]=correctNum ($calc_L[1]*$x);
        $calc_L[3]=correctNum ($calc_L[2]+$coef3_L);
        
        $tabCalc.= "<tr style='border-top: 2px solid black;'><td rowspan='2'>x[$n] = $x</td><td>:</td><td>$calc[0]</td><td>$calc[2]</td><td>$calc[4]</td></tr>
                    <tr><td>$coef1</td><td>$calc[1]</td><td>$calc[3]</td><td>$calc[5]</td></tr>";
        
        $tabCalc_L.= "<tr style='border-top: 2px solid black;'><td rowspan='2'>x[$n] = $x</td><td>:</td><td>$calc_L[0]</td><td>$calc_L[2]</td></tr>
                    <tr><td>$coef1_L</td><td>$calc_L[1]</td><td>$calc_L[3]</td></tr>";
        
        $param['f(x[n])']=$calc[5];
        $param['f\'(x[n])']=$calc_L[3];
        
        if (empty($param['f\'(x[n])'])) //экстренный выход (деление на ноль)
            return false;
            
        $param['h']=correctNum($param['f(x[n])']/$param['f\'(x[n])']);
        
        $params[$n]=$param;
        
        if (empty($param['h'])) { //сохраняем коэфициенты квадратного уравнения для подсчёта двух других корней
            $resX[0]=$x;
            $coef2=$calc[1];
            $coef3=$calc[3]+($calc[5]*(-1));
        }
        
        $x=correctNum ($x-$param['h']);
        $n++;
    }while (!empty($param['h']) && $n<56); //если замыкается, 56 последняя итерация
    
    $lastX=$params[count($params)-1]['x[n]'];
    $params[count($params)-1]['x[n]'] = "<span style='color: green;'>$lastX</span>";
    
    $d=correctNum (pow($coef2, 2)-(4*$coef1*$coef3));
    $calcSquare = "<br />D = $coef2^2 - 4*$coef1*$coef3 = $d";
    $i= ($d<0) ? 'i' : '';
    $calcSquare.="$i<br /><br />";
    $d=abs($d);
    if ($d==1) {
        $resX[1]=(-$coef2)/(2*$coef1);
        $calcSquare.="x2 = -($coef2) / (2 * $coef1) = $resX[1]<br /><br />x1 = $resX[0]";
    }
    
    $resX[1]=correctNum ((-$coef2+pow($d, 1/2))/(2*$coef1));
    $resX[2]=correctNum ((-$coef2-pow($d, 1/2))/(2*$coef1));
    $calcSquare.="x2 = (-($coef2) + $d$i^(1/2)) / (2*$coef1) = $resX[1]<br />x3 = (-($coef2) - $d$i^(1/2)) / (2*$coef1) = $resX[2]<br /><br />x1 = $resX[0]";
    
    return [$params, $tabCalc, $tabCalc_L, $calcSquare];
}
?>