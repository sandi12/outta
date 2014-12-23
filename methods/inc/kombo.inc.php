<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {
    include_once 'core/general_core.php';
    include_once 'core/core_kombo.php';
    
    $listForSend = $_POST;
    $check = true;
    foreach ($listForSend as &$item1) {
        $lastItem1 = $item1;
        $item1 = (float) $item1;
        if ($lastItem1!==(string) $item1) {
            $check=false;
            break 1;
        }
    }
    if (empty($listForSend['coef1'])) $check = false;
    $end = $listForSend['end'];
    
    $result= ($check) ? countUpKombo($listForSend) : false;
    if (!empty($result)) {
        list($mainTable, $tabCalc, $tabCalc_line, $tabCalc_deriv_line, $listOfH, $calcSquare) = $result;
?>

<head>
    <link href="styleKombo.css" type="text/css" rel="stylesheet"/>
</head>

<section id="calc">
    <div id='mainTable1'>
        <!--Вывод основной таблицы-->
        <table>
            <?= $mainTable ?>
        </table>
    </div>
    
    <div id='listOfH'>
            <!--Вывод талицы расчётов h и h with line-->
            <?= $listOfH ?>
    </div>
    
    <div id='calcTable1'>
        <!--Вывод табл. расчётов f(x[n])-->
        <table>
            <?= $tabCalc ?>
        </table>
    </div>
    
    <div id='tabCalc_line'>
        <!--Вывод табл. расчётов f(x[n] with line)-->
        <table>
            <?= $tabCalc_line ?>
        </table>
    </div>
    
    <div id='tabCalc_deriv_line'>
        <!--Вывод табл. расчётов f'(x[n] with line)-->
        <table>
        <?= $tabCalc_deriv_line ?>
        </table>
    </div>
    
    <div id='square'>
            <!--Вывод расчётов двух других корней-->
            <?= $calcSquare ?>
    </div>
    
</section>
<?php
    }
    else echo ERROR;
}
?>

<div id="form">
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
        <label>Коэф. при х в кубе: <input name="coef1" value="<? if (isset($_POST['coef1'])) echo $_POST['coef1']; ?>" required="" /></label><br />
        <label>Коэф. при х в квадрате: <input name="coef2" value="<? if (isset($_POST['coef2'])) echo $_POST['coef2']; ?>" required="" /></label><br />
        <label>Коэф. при х в первой: <input name="coef3" value="<? if (isset($_POST['coef3'])) echo $_POST['coef3']; ?>" required="" /></label><br />
        <label>Коэф. при х в нулевой: <input name="coef4" value="<? if (isset($_POST['coef4'])) echo $_POST['coef4']; ?>" required="" /></label><br /><br />
        Укажите интервал: (<input name="a" value="<? if (isset($_POST['a'])) echo $_POST['a']; ?>" required="" placeholder="a" class="interval" />; <input name="b" value="<? if (isset($_POST['b'])) echo $_POST['b']; ?>" required="" placeholder="b" class="interval" />)<br />
        Закреплённый конец<br />(в точности как было в <b>хордах</b>, 1-ом методе)<br /><br /> <label><span style="margin: 0 35px 0 90px ;">A<input name="end" type="radio" class="radio" value="0" <? if (isset($end) && empty($end)) echo 'checked'; ?> required="" /></span></label>
        <label>B<input name="end" type="radio" class="radio" value="1" <? if (isset($end) && $end == 1) echo 'checked'; ?> /></label><br /><br />
        <button class="but">Решить!</button>
    </form>
</div>