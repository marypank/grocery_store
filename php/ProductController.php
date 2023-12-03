<?php

class ProductController
{
    public function getProduts()
    {
        require "dbConnection.php";
        $query = $connection->prepare("SELECT pd.*, ct.name as category_name FROM `products` pd left join `categories` ct on pd.category_id = ct.id");
        $query->execute();
        $result = $query->get_result();

        $result = $result->fetch_all(MYSQLI_ASSOC);

        return json_encode($result);
    }

    public function changeProductQuantity()
    {
        require "dbConnection.php";
        
        $result = [
            'message' => null,
        ];

        $quantity = (int)$_POST['quantity'];
        $cancelType = (int)$_POST['cancel_type_id'];
        $productId = (int)$_POST['product_id'];

        try {
            $query = $connection->prepare("UPDATE `products` SET `quantity` = ?, `tmp_cancel_type` = ?  WHERE `id` = ?;");
            $query->bind_param('iii', $quantity, $cancelType, $productId);

            $query->execute();
            $query->get_result();

            if (mysqli_affected_rows($connection)) {
            } else {
                $result['message'] = 'Произошла ошибка при попытке обновить количество товара ('. mysqli_error($connection) .')';
            }
        } catch (\Exceptions $ex) {
            $result['message'] = 'Произошла ошибка при попытке обновить количество товара ('. $ex->getMessage() .')';
        }

        return json_encode($result);
    }
}