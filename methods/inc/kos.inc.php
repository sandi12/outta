<<<<<<< HEAD
<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {
    include_once 'core/general_core.php';
    include_once 'core/core_kos.php';
=======
<?
if ($_SERVER['REQUEST_METHOD']=='POST') {
    include 'core/core.php';
>>>>>>> 9a860c582f694fc1ab8780d33003e49fd1514afc
    
    $listForSend=$_POST;
    $check=true;
    foreach ($listForSend as &$item1) {
        $lastItem1=$item1;
        $item1 = (float) $item1;
        if ($lastItem1!==(string) $item1) {
            $check=false;
            break 1;
        }
    }
    if (empty($listForSend['coef1'])) $check=false;             //verification of existing the first coef of square equation
    $result= ($check) ? countUpKos($listForSend) : false;
    if (!empty($result)) {
        list($params, $tabCalc, $tabCalc_L, $calcSquare)=$result;
    
?>
<section id="calc">
    <div id='calcH'>
        <table><!--Вывод талицы расчётов-->
            <?= $tabCalc ?>
        </table>
    </div>
    
    <div id='calcTable' style="margin-left: 110px;">
        <table><!--Вывод талицы расчётов-->
            <?= $tabCalc_L ?>
        </table>
    </div>
    
    <div id="mainTable">
        <table><!--Вывод основной таблицы-->
            <tr><th>n</th><th>x[n]</th><th>f(x[n])</th><th>f'(x[n])</th><th>h</th></tr>
            <?
<<<<<<< HEAD
            foreach ($params as $item) {
                echo "<tr><td>{$item['id']}</td><td>{$item['x[n]']}</td><td>{$item['f(x[n])']}</td><td>{$item['f\'(x[n])']}</td><td>{$item['h']}</td></tr>";
            }
=======
            foreach ($params as $item)
                echo "<tr><td>{$item['id']}</td><td>{$item['x[n]']}</td><td>{$item['f(x[n])']}</td><td>{$item['f\'(x[n])']}</td><td>{$item['h']}</td></tr>";
>>>>>>> 9a860c582f694fc1ab8780d33003e49fd1514afc
            ?>
        </table>
    </div>
    
    <div>
        <?= $calcSquare ?>
    </div>
</section>
<<<<<<< HEAD
<?php
    }
    else echo ERROR;
=======
<?
    }
    else echo '<span style="color: red;"><br />О нет, что-то пошло не так<br />Деление на ноль или замыкание<br />Проверьте введённые данные<br />99.9999999% вероятность, что ошибся именно ты<br />Обрати внимание на минусы (должен быть самый маленький)</span><hr />';
>>>>>>> 9a860c582f694fc1ab8780d33003e49fd1514afc
}
?>

<div id="form">
        <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
            <label>Коэф. при х в кубе: <input name="coef1" value="<? if (isset($_POST['coef1'])) echo $_POST['coef1']; ?>" required="" /></label><br />
            <label>Коэф. при х в квадрате: <input name="coef2" value="<? if (isset($_POST['coef2'])) echo $_POST['coef2']; ?>" required="" /></label><br />
            <label>Коэф. при х в первой: <input name="coef3" value="<? if (isset($_POST['coef3'])) echo $_POST['coef3']; ?>" required="" /></label><br />
            <label>Коэф. при х в нулевой: <input name="coef4" value="<? if (isset($_POST['coef4'])) echo $_POST['coef4']; ?>" required="" /></label><br /><br />
            <label>Значение х[n] при n=0: <input name="x" value="<? if (isset($_POST['x'])) echo $_POST['x']; ?>" required="" /></label><br />
            <button class="but">Считаем</button>
        </form>
</div>