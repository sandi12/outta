<? 
header('Content-Type: text/html; charset=utf-8');
header('Cashe-Control: max-age=36000'); 
include 'inc/headers.inc.php';
/*http://outta123.hol.es/methods/*/
/*http://php.local/methods/*/
define('MAIN_WAY', 'http://outta123.hol.es/methods/');
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
                <li><a href="<?= MAIN_WAY ?>?id=hords" >Хорды</a></li>
                <li><a href="<?= MAIN_WAY ?>?id=kos" >Косатин</a></li>
            </ul>
        </nav>
        <h1 id='header1'><?= $header ?></h1>
        <? include "inc/$way"; ?>
    </section>
</body>
</html>