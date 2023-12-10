<?php

class CancelTypeController
{
    private $connection;

    public function __construct()
    {
        require "dbConnection.php";
        $this->connection = $connection;
    }

    public function getTypes()
    {
        $query = $this->connection->prepare("SELECT * FROM `cancel_type` ORDER BY `id`");
        $query->execute();
        $result = $query->get_result();
        
        $result = $result->fetch_all(MYSQLI_ASSOC);

        return json_encode($result);
    }

    public function update()
    {
        $result = [
            'message' => null,
        ];

        $id = $_POST['cancel_type_id'];
        $newName = $_POST['new_name'];

        try {
            $query = $this->connection->prepare("UPDATE `cancel_type` SET `name` = ? WHERE `id` = ?;");
            $query->bind_param('si', $newName, $id);

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($this->connection)) {
                header('Location: ../index_types.php');
            } else {
                $result['message'] = 'Произошла ошибка при попытке обновить тип списания ('. mysqli_error($this->connection) .')';
            }
        } catch (\Exception $ex) {
            $result['message'] = 'Произошла ошибка при попытке обновить тип списания ('. $ex->getMessage() .')';
        }

        return json_encode($result);
    }

    public function create()
    {
        $result = [
            'message' => null,
        ];

        $name = $_POST['name'];

        try {
            $query = $this->connection->prepare("INSERT INTO `cancel_type` (`name`) VALUES (?);");
            $query->bind_param('s', $name);

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($this->connection)) {
                header('Location: ../index_types.php');
            } else {
                $result['message'] = 'Произошла ошибка при попытке создать тип списания ('. mysqli_error($this->connection) .')';
            }
        } catch (\Exception $ex) {
            $result['message'] = 'Произошла ошибка при попытке создать тип списания ('. $ex->getMessage() .')';
        }

        return json_encode($result);
    }

    public function delete(int $id)
    {
        $result['message'] = null;

        try {
            $query = $this->connection->prepare("DELETE FROM `cancel_type` WHERE `id` = ?");
            $query->bind_param('i', $id);

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($this->connection)) {
                header('Location: ../index_types.php');
            } else {
                $result['message'] = 'Произошла ошибка при попытке удаления категории ('. mysqli_error($this->connection) .')';
            }
        } catch (\Exception $ex) {
            $result['message'] = 'Произошла ошибка при попытке удаления категории ('. $ex->getMessage() .')';
        }

        return json_decode($result);
    }

    public function getCancelTypeById(int $id)
    {
        $query = $this->connection->prepare("SELECT * FROM `cancel_type` WHERE `id` = ?");
        $query->bind_param('i', $id);
        $query->execute();
        $result = $query->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}