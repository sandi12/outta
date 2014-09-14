<?
    $title = 'Главная';
    $header = 'Welcome';
    $way='index.inc.php';
    if (!empty($_GET['id'])) {
        $id = strtolower(strip_tags(trim($_GET['id'])));
        // Инициализация заголовков страницы
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