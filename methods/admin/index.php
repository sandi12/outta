<?php
header('Content-Type: text/html; charset=utf-8');
header('Cashe-Control: max-age=36000');
ob_start();
define('MAIN_WAY', 'http://outta123.atwebpages.com/methods/admin');
/*http://outta123.hol.es/methods*/
/*http://php.local/methods*/
/*http://outta123.atwebpages.com/methods*/

include_once 'allowableIP.php';
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Пульт управления</title>
<link href="style.css" type="text/css" rel="stylesheet"/>
</head>
<body>
    <section id="main">
        <?php
        $nowIP = $_SERVER['REMOTE_ADDR'];
        if (!empty($listOfIp[$nowIP])) include_once 'check.php';
         
        ?>
    </section>
</body>
</html>

