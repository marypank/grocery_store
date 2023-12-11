<?php

class ProductController
{
    private $connection;
    private $cancelTypeController;

    public const CREATE_OPERATION_TYPE = 'CREATE';
    public const UPDATE_OPERATION_TYPE = 'UPDATE';
    public const DELETE_OPERATION_TYPE = 'DELETE';

    public const PRICE_COL = 'price';
    public const QUANT_COL = 'quantity';

    public function __construct()
    {
        require "dbConnection.php";
        require "CancelTypeController.php";
        $this->connection = $connection;
        $this->cancelTypeController = new CancelTypeController();
    }

    public function getProduts()
    {
        $query = $this->connection->prepare("SELECT pd.*, ct.name as category_name FROM `products` pd left join `categories` ct on pd.category_id = ct.id ORDER BY pd.id");
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

        $product = $this->getProductById($productId);
        $product = current($product);

        try {
            $query = $this->connection->prepare("UPDATE `products` SET `quantity` = ? WHERE `id` = ?;");
            $query->bind_param('ii', $quantity, $productId);

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($this->connection)) {
                $cancelType = $this->cancelTypeController->getCancelTypeById($cancelType);
                $cancelType = current($cancelType);
                $cancelTypeText = $cancelType['name'] ?? null;
                if ($cancelTypeText) {
                    $this->registerChanges(self::UPDATE_OPERATION_TYPE, $product['quantity'], $quantity, $cancelTypeText, $productId, null);
                }

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
        $result = $this->getProductById($id);

        if (!$result) {
            header('Location: ../index.php');
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
        $login = $_SESSION['store_login'];

        $pattern = '/^\d+(\.\d{2})?$/';
        if (!preg_match($pattern, $price)) {
            $result['message'] = 'Произошла ошибка при попытке обновить данные (Цена написана неверно)';
            return json_encode($result);
        }
        if ((int)$quantity < 0) {
            $result['message'] = 'Произошла ошибка при попытке обновить данные (Количество неверно)';
            return json_encode($result);
        }

        $product = $this->getProductById($productId);
        $product = current($product);

        try {
            if (is_null($cancelTypeId)) {
                $query = $this->connection->prepare("UPDATE `products` SET `name` = ?, `description` = ?, `price` = ?, `category_id` = ? WHERE `id` = ?;");
                $query->bind_param('ssdii', $name, $descr, $price, $categoryId, $productId);
            } else {
                $query = $this->connection->prepare("UPDATE `products` SET `name` = ?, `description` = ?, `price` = ?, `quantity` = ?, `category_id` = ?  WHERE `id` = ?;");
                $query->bind_param('ssdiii', $name, $descr, $price, $quantity, $categoryId, $productId);
            }

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($this->connection)) {
                if (!is_null($cancelTypeId)) {
                    $cancelType = $this->cancelTypeController->getCancelTypeById($cancelTypeId);
                    $cancelType = current($cancelType);
                    $cancelTypeText = $cancelType['name'] ?? null;
                    if ($cancelTypeText) {
                        $this->registerChanges(self::UPDATE_OPERATION_TYPE, $product['quantity'], $quantity, $cancelTypeText, $productId, null);
                    }
                }
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
        $login = $_SESSION['store_login'];

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
            $query = $this->connection->prepare("INSERT INTO `products` (`name`, `description`, `price`, `quantity`, `category_id`, `who_login`) VALUES (?, ?, ?, ?, ?, ?);");
            $query->bind_param('ssdiis', $name, $descr, $price, $quantity, $categoryId, $login);

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($this->connection)) {
                $cancelType = $this->cancelTypeController->getCancelTypeById($cancelTypeId);
                $cancelType = current($cancelType);
                $cancelTypeText = $cancelType['name'] ?? null;
                $productId = mysqli_insert_id($this->connection) ?? null;
                if ($cancelTypeText && $productId) {
                    $this->registerChanges(self::CREATE_OPERATION_TYPE, null, $quantity, $cancelTypeText, $productId, null);
                }

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
            $product = $this->getProductById($id);
            $product = current($product);

            $query = $this->connection->prepare("DELETE FROM products WHERE `products`.`id` = ?");
            $query->bind_param('i', $id);

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($this->connection)) {
                $this->registerChanges(self::DELETE_OPERATION_TYPE, null, null, null, $id, $product['name']);

                header('Location: ../index.php');
            } else {
                $result['message'] = 'Произошла ошибка при попытке удаления товара/продукта ('. mysqli_error($this->connection) .')';
            }
        } catch (\Exception $ex) {
            $result['message'] = 'Произошла ошибка при попытке удаления товара/продукта ('. $ex->getMessage() .')';
        }

        return $result;
    }

    private function getProductById(int $id)
    {
        $query = $this->connection->prepare("SELECT pd.*, ct.name as category_name, ct.id as id_category FROM `products` pd left join `categories` ct on pd.category_id = ct.id WHERE pd.id = ?");
        $query->bind_param('i', $id);
        $query->execute();
        $result = $query->get_result();


        return $result->fetch_all(MYSQLI_ASSOC);
    }

    private function registerChanges(string $opType, $oldValue = null, $newValue = null, $cancelTypeText = null, $productId = null, $productName = null)
    {
        $message = null;
        $login = $_SESSION['store_login'];
        if ($opType == self::CREATE_OPERATION_TYPE) {
            try {
                $query = $this->connection->prepare("INSERT INTO `products_quantity_his` (`product_id`, `product_name`, `old_val`, `new_val`, `cancel_type_text`, `op_type`, `who`) VALUES (?, null, null, ?, ?, ?, ?);");
                $query->bind_param('issss', $productId, $newValue, $cancelTypeText, $opType, $login);
                $query->execute();
                $query->get_result();

                if (mysqli_affected_rows($this->connection)) {
                } else {
                    $message = 'Товар успешно обновлен/добавлен/удален, но при попытке зарегистировать историю товара произошла ошибка';
                }
            } catch (\Exception $ex) {
                $message = 'Товар успешно обновлен/добавлен/удален, но при попытке зарегистировать историю товара произошла ошибка';
            }
        }
        if ($opType == self::UPDATE_OPERATION_TYPE) {
            try {
                $query = $this->connection->prepare("INSERT INTO `products_quantity_his` (`product_id`, `product_name`, `old_val`, `new_val`, `cancel_type_text`, `op_type`, `who`) VALUES (?, null, ?, ?, ?, ?, ?);");
                $query->bind_param('isssss', $productId, $oldValue, $newValue, $cancelTypeText, $opType, $login);
                $query->execute();
                $query->get_result();

                if (mysqli_affected_rows($this->connection)) {
                } else {
                    $message = 'Товар успешно обновлен/добавлен/удален, но при попытке зарегистировать историю товара произошла ошибка';
                }
            } catch (\Exception $ex) {
                $message = 'Товар успешно обновлен/добавлен/удален, но при попытке зарегистировать историю товара произошла ошибка';
            }
        }
        if ($opType == self::DELETE_OPERATION_TYPE) {
            try {
                $query = $this->connection->prepare("INSERT INTO `products_quantity_his` (`product_id`, `product_name`, `old_val`, `new_val`, `cancel_type_text`, `op_type`, `who`) VALUES (?, ?, null, null, null, ?, ?);");
                $query->bind_param('isss', $productId, $productName, $opType, $login);
                $query->execute();
                $query->get_result();

                if (mysqli_affected_rows($this->connection)) {
                } else {
                    $message = 'Товар успешно обновлен/добавлен/удален, но при попытке зарегистировать историю товара произошла ошибка';
                }
            } catch (\Exception $ex) {
                $message = 'Товар успешно обновлен/добавлен/удален, но при попытке зарегистировать историю товара произошла ошибка';
            }
        }

        return $message;
    }
}