<?php
//this func accept file's name and return array with unserialize items
function serFile($filename) {
    $list = file($filename);
    $res = [];
    foreach ($list as $item) {
        $item = unserialize($item);
        $res[$item['ip']] = $item;
    }
    return $res;
}

$list = serFile(ADMIN_LOG);

include_once 'proc.php';

if (isset($_POST['itemForShow'])) {
    $itemForShow = $_POST['itemForShow'];
    list($info, $tableWay) = getFromFile($itemForShow, $list);
}

if (isset($_GET['action'])) {
    $action = strtolower(strip_tags(trim($_GET['action'])));
    $num= (isset($_GET['num'])) ? strtolower(strip_tags(trim($_GET['num']))) : false;
    switch ($action) {
        case 'cleanway' :
            if ($num) delWays($num, $list);
            break 1;
        case 'delone' :
            if (count($list)==1) delAll();
            elseif ($num) delOne($num, $list);
            break 1;
        case 'delall' :
            delAll();
    }
    header('Location: '.MAIN_WAY);
    die();
}
?>
<section id="form">
    <?= 'Amount of visitors: '.count($list).'<br /><br />'; ?>
    <form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>" >
            <select name='itemForShow' required >
                <?php
                reset($list);
                $dateInOpt = getFirstDate($list[key($list)]['firstVis']);
                echo "<optgroup label='{$dateInOpt}'>\n";
                foreach ($list as $item) {
                    $currentDate = getFirstDate($item['firstVis']);
                    if ($dateInOpt != $currentDate) {
                        $dateInOpt = $currentDate;
                        echo "</optgroup>\n
                              <optgroup label='{$dateInOpt}'>\n";
                    }
                    $sel= (isset($itemForShow) && ($item['ip']==$itemForShow)) ? 'selected' : '';
                    echo "<option value='{$item['ip']}' {$sel} >{$item['ip']}</option>\n";
                }
                echo "</optgroup>\n";
                ?>
            </select><br /><br />
            <button>Get<br />information</button>
    </form>
</section>

<?php
if (isset($itemForShow)) {
?>

<aside id="buttons">
    <button onclick="location.href='<?= MAIN_WAY.'?action=cleanWay&num='.$itemForShow ?>'">Очистить<br />журнал<br />передвижений</button>
    <button onclick="location.href='<?= MAIN_WAY.'?action=delOne&num='.$itemForShow ?>'" id="middleBut">Удалить запись</button>
    <button onclick="location.href='<?= MAIN_WAY.'?action=delAll' ?>'">Очистить базу</button>
</aside>

<div>
    <?= $info ?>
</div>

<table id='t1'>
    <tr><th>Time</th><th>Way</th></tr>
    <?= $tableWay ?>
</table>

<?php
}
?>