<?php

function corFile(array $list) {
    $handle=fopen(ADMIN_LOG, 'w'); //have made rewriting
    fclose($handle);
    foreach ($list as $item) {
        file_put_contents(ADMIN_LOG, serialize($item)."\n", FILE_APPEND);
    }
    return true;
}

function getFirstDate($arg) {
    return strftime('%d-%b-%Y', $arg);
}

function getFromFile($id, array $list) {
    $item = $list[$id];
    $soft='';
    foreach ($item['soft'] as $one) $soft .=  $one.'<br/>';
    $info = "<p><span class='weight'>ip-address:</span> {$item['ip']}</p>\n
            <p><span class='weight'>Browser</span><br /> {$soft}</p>\n
            <p><span class='weight'>From:</span> {$item['ref']}</p>\n
            <p><span class='weight'>Amount of visitings:</span> {$item['amountVis']}</p>\n
            <h2 style='text-align:center;'>Visited pages</h2\n>";

    $tableWay = '';
    foreach ($item['listPage'] as $item1) {
        $dmy = strftime('%d-%b-%Y', $item1['time']);
        $h = ((integer) strftime('%H', $item1['time'])) + 3;
        $ms = strftime('%M:%S', $item1['time']);
        $tableWay.= "<tr><td><span style='margin: 0 120px 0 20px'>{$dmy}</span><span>{$h}:{$ms}</span></td>
              <td>{$item1['addr']}<span style='float: right; margin-right: 50px;'>{$item1['method']}</span></td></tr>\n";
    }
    return [$info, $tableWay];
}

function delWays($id, array $list) {
    $list[$id]['listPage'] = [];
    corFile($list);
    return true;
}

function delOne($id, array $list) {
    unset($list[$id]);
    corFile($list);
    return true;
}

function delAll() {
    unlink(ADMIN_LOG);
    return true;
}

?>