<?php

class UserController
{
    public function login()
    {
        require_once "dbConnection.php";
        
        $login = $_POST['login'];
        $password = $_POST['password'];
        $password = md5($password . 'gbsd2342dg');

        $query = $connection->prepare("SELECT * FROM `users` WHERE `user_name` = ? AND `password` = ?");
        $query->bind_param('ss', $login, $password);

        $query->execute();
        $result = $query->get_result();

        if (!mysqli_num_rows($result)) {
            return [
                'success' => false,
                'message' => 'Логин или пароль неверные.',
                'data' => [
                    'login' => $login,
                    'password' => '',
                ],
            ];
        }

        $result = $result->fetch_assoc();

        $_SESSION['store_login'] = $result['user_name'];
        $_SESSION['store_name'] = $result['full_name'];
		
        return $response = [
            'success' => true,
            'message' => '',
            'data' => [],
        ];
    }

    public function register()
    {
        //
    }

    public function logout()
    {
        // require "dbConnection.php" ;

	    // unset($_SESSION['session_username'] );
	    // header('Location: ../login.php');
    }
}