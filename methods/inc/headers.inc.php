<<<<<<< HEAD
<?php
$title = 'Главная';
$header = 'Welcome';
$way = 'index.inc.php';
if (!empty($_GET['id'])) {
    $id = strtolower(strip_tags(trim($_GET['id'])));
    // initalization page's headers
    switch($id){
        case 'hords': 
        	$title = 'Хорды';
        	$header = 'Метод хорд';
            $way = 'hords.inc.php';
        	break;
        case 'kos': 
        	$title = 'Касательные';
        	$header = 'Метод касательных';
            $way = 'kos.inc.php';
        	break;
        case 'kombo': 
        	$title = 'Комбо';
        	$header = 'Комбинированный метод';
            $way = 'kombo.inc.php';
        	break;
    }
}
=======
<?
    $title = 'Главная';
    $header = 'Welcome';
    $way='index.inc.php';
    if (!empty($_GET['id'])) {
        $id = strtolower(strip_tags(trim($_GET['id'])));
        // initalization page's headers
        switch($id){
        	case 'hords': 
        		$title = 'Хорды';
        		$header = 'Метод хорд';
                $way='hords.inc.php';
        		break;
        	case 'kos': 
        		$title = 'Косатин';
        		$header = 'Метод Косатина';
                $way='kos.inc.php';
        		break;
        }
    }
?>
>>>>>>> 9a860c582f694fc1ab8780d33003e49fd1514afc
