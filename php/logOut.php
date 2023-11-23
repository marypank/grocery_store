<?php
	require "dbConnection.php" ;

	unset($_SESSION['session_username'] );
	header('Location: ../login.php');
?>