<<<<<<< HEAD
<?php
header('Content-Type: text/html; charset=utf-8');
header('Cashe-Control: max-age=36000');

define('MAIN_WAY', 'http://php.local/methods');
define('ERROR', '<span style="color: red;"><br />О нет, что-то пошло не так<br />
                    Деление на ноль или замыкание<br />Проверьте введённые данные<br />
                    99.9999999% вероятность, что ошибся именно ты<br />
                    Обрати внимание на минусы и точки отделения дробной части<br />
                    (минус должен быть самый маленький)</span><hr />');

include_once 'inc/headers.inc.php';
include_once 'inc/writeToAdmin.php';
/*http://outta123.hol.es/methods*/
/*http://php.local/methods*/
/*http://outta123.atwebpages.com/methods*/

=======
<? 
header('Content-Type: text/html; charset=utf-8');
header('Cashe-Control: max-age=36000'); 
include 'inc/headers.inc.php';
/*http://outta123.hol.es/methods/*/
/*http://php.local/methods/*/
define('MAIN_WAY', 'http://outta123.hol.es/methods/');
>>>>>>> 9a860c582f694fc1ab8780d33003e49fd1514afc
?>

<!DOCTYPE HTML>
<html>
<head>
<title><?= $title ?></title>
<link href="style.css" type="text/css" rel="stylesheet"/>
</head>
<body>
    <section id="main">
        <nav>
            <ul id="links">
                <li><a href="<?= MAIN_WAY ?>" >Главная</a></li>
<<<<<<< HEAD
                <li><a href="<?= MAIN_WAY.'?id=hords' ?>" >Хорды</a></li>
                <li><a href="<?= MAIN_WAY.'?id=kos' ?>" >Касательные</a></li>
                <li id="kombo"><a href="<?= MAIN_WAY.'?id=kombo' ?>" >Комбо <sup>для К/Р</sup></a></li>
            </ul>
        </nav>
        <h1 id='header1'><?= $header ?></h1>
        <?php include_once "inc/$way"; ?>
=======
                <li><a href="<?= MAIN_WAY ?>?id=hords" >Хорды</a></li>
                <li><a href="<?= MAIN_WAY ?>?id=kos" >Косатин</a></li>
            </ul>
        </nav>
        <h1 id='header1'><?= $header ?></h1>
        <? include "inc/$way"; ?>
>>>>>>> 9a860c582f694fc1ab8780d33003e49fd1514afc
    </section>
</body>
</html>