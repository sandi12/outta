<?php
define('ADMIN_LOG', 'admin.log');

if (is_file(ADMIN_LOG)) include_once 'view.php';
else echo '<h3>Файл не существует!</h3>';
