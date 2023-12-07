<?php

class ProductController
{
    private $connection;

    public function __construct()
    {
        require "dbConnection.php";
        $this->connection = $connection;
    }

    public function getProduts()
    {
        $query = $this->connection->prepare("SELECT pd.*, ct.name as category_name FROM `products` pd left join `categories` ct on pd.category_id = ct.id");
        $query->execute();
        $result = $query->get_result();

        $result = $result->fetch_all(MYSQLI_ASSOC);

        return json_encode($result);
    }

    public function changeProductQuantity()
    {
        $result = [
            'message' => null,
        ];

        $quantity = (int)$_POST['quantity'];
        $cancelType = (int)$_POST['cancel_type_id'];
        $productId = (int)$_POST['product_id'];

        try {
            $query = $this->connection->prepare("UPDATE `products` SET `quantity` = ?, `tmp_cancel_type` = ?  WHERE `id` = ?;");
            $query->bind_param('iii', $quantity, $cancelType, $productId);

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($this->connection)) {
            } else {
                $result['message'] = 'Произошла ошибка при попытке обновить количество товара ('. mysqli_error($this->connection) .')';
            }
        } catch (\Exception $ex) {
            $result['message'] = 'Произошла ошибка при попытке обновить количество товара ('. $ex->getMessage() .')';
        }

        return json_encode($result);
    }

    public function getProductDetails(int $id)
    {
        $query = $this->connection->prepare("SELECT pd.*, ct.name as category_name, ct.id as id_category FROM `products` pd left join `categories` ct on pd.category_id = ct.id WHERE pd.id = ?");
        $query->bind_param('i', $id);
        $query->execute();
        $result = $query->get_result();

        $result = $result->fetch_all(MYSQLI_ASSOC);

        if (!$result) {
            // header('Location: ../index.php');
        }

        return json_encode($result);
    }

    public function update()
    {
        $result['message'] = null;
        $productId = $_POST['product_id'];
        $name = $_POST['name'];
        $descr = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $cancelTypeId = $_POST['cancel_type_id'] ?? null;
        $categoryId = $_POST['category_id'];

        $pattern = '/^\d+(\.\d{2})?$/';
        if (!preg_match($pattern, $price)) {
            $result['message'] = 'Произошла ошибка при попытке обновить данные (Цена написана неверно)';
            return json_encode($result);
        }
        if ((int)$quantity < 0) {
            $result['message'] = 'Произошла ошибка при попытке обновить данные (Количество неверно)';
            return json_encode($result);
        }

        try {
            if (is_null($cancelTypeId)) {
                $query = $this->connection->prepare("UPDATE `products` SET `name` = ?, `description` = ?, `price` = ?, `category_id` = ? WHERE `id` = ?;");
                $query->bind_param('ssdii', $name, $descr, $price, $categoryId, $productId);
            } else {
                $query = $this->connection->prepare("UPDATE `products` SET `name` = ?, `description` = ?, `price` = ?, `quantity` = ?, `category_id` = ?, `tmp_cancel_type` = ?  WHERE `id` = ?;");
                $query->bind_param('ssdiiii', $name, $descr, $price, $quantity, $categoryId, $cancelTypeId, $productId);
            }

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($this->connection)) {
            } else {
                $result['message'] = 'Произошла ошибка при попытке обновить данные ('. mysqli_error($this->connection) .')';
            }
        } catch (\Exception $ex) {
            $result['message'] = 'Произошла ошибка при попытке обновить данные ('. $ex->getMessage() .')';
        }

        return json_encode($result);
    }

    public function create()
    {
        $name = $_POST['name'];
        $descr = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $cancelTypeId = 1; // (!) 1 - ВСЕГДА поступление/приход товара
        $categoryId = $_POST['category_id'];

        $result = [
            'message' => null,
            'data' => [
                'name' => $name,
                'description' => $descr,
                'price' => $price,
                'quantity' => $quantity
            ],
        ];


        $pattern = '/^\d+(\.\d{2})?$/';
        if (!preg_match($pattern, $price)) {
            $result['message'] = 'Произошла ошибка при попытке создания товара/продукта (Цена написана неверно)';
            return json_encode($result);
        }
        if ((int)$quantity < 0) {
            $result['message'] = 'Произошла ошибка при попытке создания товара/продукта (Количество неверно)';
            return json_encode($result);
        }

        try {
            $query = $this->connection->prepare("INSERT INTO `products` (`name`, `description`, `price`, `quantity`, `category_id`, `tmp_cancel_type`) VALUES (?, ?, ?, ?, ?, ?);");
            $query->bind_param('ssdiii', $name, $descr, $price, $quantity, $categoryId, $cancelTypeId);

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($this->connection)) {
                header('Location: ../index.php');
            } else {
                $result['message'] = 'Произошла ошибка при попытке создания товара/продукта ('. mysqli_error($this->connection) .')';
            }
        } catch (\Exception $ex) {
            $result['message'] = 'Произошла ошибка при попытке создания товара/продукта ('. $ex->getMessage() .')';
        }

        return json_encode($result);
    }

    public function delete(int $id)
    {
        $result['message'] = null;
        try {
            $query = $this->connection->prepare("DELETE FROM products WHERE `products`.`id` = ?");
            $query->bind_param('i', $id);

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($this->connection)) {
                header('Location: ../index.php');
            } else {
                $result['message'] = 'Произошла ошибка при попытке удаления товара/продукта ('. mysqli_error($this->connection) .')';
            }
        } catch (\Exception $ex) {
            $result['message'] = 'Произошла ошибка при попытке удаления товара/продукта ('. $ex->getMessage() .')';
        }

        return $result;
    }
}