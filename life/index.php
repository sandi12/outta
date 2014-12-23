<?php
header('Content-Type: text/html; charset=utf-8');
header('Cache-control: no-store');
define('MAIN_WAY', 'http://php.local/life/');

/*http://outta123.hol.es/*/
/*http://php.local/life/*/
?>

<html>
    <head>
        <title>Game Life</title>
        <link rel="shortcut icon" href="img/tree.ico" type="image/x-icon"/>
        <link href="style/main.css" type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <?php
        if (isset($_GET['where']) && $_GET['where'] == 'input') {
            require_once 'game.html';
        } else {
            require_once 'welcome.html';
        }

        ?>
    </body>
</html>