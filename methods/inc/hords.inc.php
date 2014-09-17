<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {
    include_once 'core/core.php';
    
    $listForSend = $_POST;
    $check = true;
    foreach ($listForSend as &$item1) {
        $lastItem1=$item1;
        $item1 = (float) $item1;
        if ($lastItem1!==(string) $item1) {
            $check=false;
            break 1;
        }
    }
    if (empty($listForSend['coef1'])) $check=false;
    $end = $listForSend['end'];
    
    $result= ($check) ? countUpHords($listForSend) : false;
    if (!empty($result)) {
        list($params, $tabCalc, $listOfH)=$result;
?>
<section id="calc">
    <div id="calcH"><!--Вывод рассчётов h-->
        <?= $listOfH ?>
    </div>
    <div id='calcTable'>
        <table><!--Вывод талицы расчётов-->
            <?= $tabCalc ?>
        </table>
    </div>
    
    <div id="mainTable">
        <table><!--Вывод основной таблицы-->
            <tr><th>n</th><th>x[n]</th><th>f(x[n])</th><th><? echo (empty($end)) ? 'x[n]-a' : 'b-x[n]'; ?></th><th><? echo (empty($end)) ? 'f(x[n])-f(a)' : 'f(b)-f(x[n])'; ?></th><th>h</th></tr>
            <?
            foreach ($params as $item)
                echo "<tr><td>{$item['id']}</td><td>{$item['x[n]']}</td><td>{$item['f(x[n])']}</td><td>{$item['a/b']}</td><td>{$item['f(a/b)']}</td><td>{$item['h']}</td></tr>";
            ?>
        </table>
    </div>
</section>
<?php
    }
    else echo '<span style="color: red;"><br />О нет, что-то пошло не так<br />Деление на ноль или замыкание<br />Проверьте введённые данные<br />99.9999999% вероятность, что ошибся именно ты<br />Обрати внимание на минусы (должен быть самый маленький)</span><hr />';
}
?>

<div id="form">
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
        <label>Коэф. при х в кубе: <input name="coef1" value="<? if (isset($_POST['coef1'])) echo $_POST['coef1']; ?>" required="" /></label><br />
        <label>Коэф. при х в квадрате: <input name="coef2" value="<? if (isset($_POST['coef2'])) echo $_POST['coef2']; ?>" required="" /></label><br />
        <label>Коэф. при х в первой: <input name="coef3" value="<? if (isset($_POST['coef3'])) echo $_POST['coef3']; ?>" required="" /></label><br />
        <label>Коэф. при х в нулевой: <input name="coef4" value="<? if (isset($_POST['coef4'])) echo $_POST['coef4']; ?>" required="" /></label><br /><br />
        Укажите интервал: (<input name="a" value="<? if (isset($_POST['a'])) echo $_POST['a']; ?>" required="" placeholder="a" class="interval" />; <input name="b" value="<? if (isset($_POST['b'])) echo $_POST['b']; ?>" required="" placeholder="b" class="interval" />)<br />
        Закреплённый конец: <label><span style="margin: 0 35px 0 30px ;">A<input name="end" type="radio" class="radio" value="0" <? if (isset($end) && empty($end)) echo 'checked'; ?> required="" /></span></label>
        <label>B<input name="end" type="radio" class="radio" value="1" <? if (isset($end) && $end == 1) echo 'checked'; ?> /></label><br /><br />
        <button class="but">Поехали!</button>
    </form>
</div>