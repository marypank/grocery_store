<?php
$connection = mysqli_connect('localhost', 'root', '', 'grocery_store');
 
if (!$connection)
{
	echo "Не подключается БД, ошибка какая-то! <br>";
	echo mysqli_connect_error();
	exit();
}
			
//session_start();

if(session_id() == '') {
    session_start();
}

?>