<?php

class UserController
{
    private $connection;

    public function __construct()
    {
        require "dbConnection.php";
        $this->connection = $connection;
    }

    public function getAllUsers()
    {
        $query = $this->connection->prepare("SELECT id, user_name, full_name, access FROM `users`");
        $query->execute();
        $result = $query->get_result();

        $result = $result->fetch_all(MYSQLI_ASSOC);

        return json_encode($result);
    }

    public function login()
    {
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
        $login = $_POST['login'];
        $fio = $_POST['fio'];
        $password = $_POST['password'];
        $password = md5($password . 'gbsd2342dg');

        $query = $this->connection->prepare("INSERT INTO `users` (`user_name`, `full_name`, `password`) VALUES (?, ?, ?);");
        $query->bind_param('sss', $login, $fio, $password);

        $query->execute();
        $query->get_result();

        if (mysqli_affected_rows($this->connection)) {
            header('Location: ../index_users.php');
        } else {
            return [
                'success' => false,
                'message' => 'Произошла ошибка при создании пользователя',
                'data' => [
                    'login' => $login,
                    'fio' => $fio,
                    'password' => '',
                ],
            ];
        }

        return $response = [
            'success' => true,
            'message' => null,
            'data' => [],
        ];
    }

    public function logout()
    {
        unset($_SESSION['store_access']);
        unset($_SESSION['store_name']);
        unset($_SESSION['store_login']);

        header('Location: ../login.php');
    }

    public function deleteUser(int $id)
    {
        $result['message'] = null;

        try {
            $query = $this->connection->prepare("DELETE FROM `categories` WHERE `id` = ?");
            $query->bind_param('i', $id);

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($this->connection)) {
                header('Location: ../index_users.php');
            } else {
                $result['message'] = 'Произошла ошибка при попытке удаления пользователя ('. mysqli_error($this->connection) .')';
            }
        } catch (\Exception $ex) {
            $result['message'] = 'Произошла ошибка при попытке удаления пользователя ('. $ex->getMessage() .')';
        }

        return json_encode($result);
    }

    public function changeAccess()
    {
        $result['message'] = null;

        $userId = $_POST['user_id'];
        $access = (int)$_POST['access'];
        $access = (int)!$access;

        try {
            $query = $this->connection->prepare("UPDATE `users` SET `access` = ? WHERE `id` = ?;");
            $query->bind_param('ii', $access, $userId);

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($this->connection)) {
                header('Location: ../index_users.php');
            } else {
                $result['message'] = 'Произошла ошибка при попытке обновления прав пользователя ('. mysqli_error($this->connection) .')';
            }
        } catch (\Exception $ex) {
            $result['message'] = 'Произошла ошибка при попытке обновления прав пользователя ('. $ex->getMessage() .')';
        }

        return json_encode($result);
    }
}