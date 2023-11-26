<?php
$connection = mysqli_connect('localhost', 'root', '', 'grocery_store');

mysqli_set_charset($connection, 'utf8');

if (!$connection)
{
	echo "Не подключается БД, ошибка какая-то! <br>";
	echo mysqli_connect_error();
	exit();
}

if(session_id() == '') {
    session_start();
}


// ALTER TABLE products ADD CONSTRAINT FOREIGN KEY (category_id) REFERENCES categories(id) ON UPDATE CASCADE ON DELETE SET NULL;


?>