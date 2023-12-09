<?php

class UserController
{
    private $connection;

    public function __construct()
    {
        require "dbConnection.php";
        $this->connection = $connection;
    }

    public function login()
    {
        require_once "dbConnection.php";
        
        $login = $_POST['login'];
        $password = $_POST['password'];
        $password = md5($password . 'gbsd2342dg');

        $query = $this->connection->prepare("SELECT * FROM `users` WHERE `user_name` = ? AND `password` = ?");
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
        $_SESSION['store_access'] = $result['access'];

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
        unset($_SESSION['store_access']);
        unset($_SESSION['store_name']);
        unset($_SESSION['store_login']);

        header('Location: ../login.php');
    }
}