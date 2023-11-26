<?php

class ProductController
{
    public function getProduts()
    {
        require_once "dbConnection.php";
        $query = $connection->prepare("SELECT pd.*, ct.name as category_name FROM `products` pd left join `categories` ct on pd.category_id = ct.id");
        $query->execute();
        $result = $query->get_result();
        
        // var_dump($result);

        // if (!mysqli_num_rows($result)) {}

        $result = $result->fetch_all(MYSQLI_ASSOC);

        return json_encode($result);
    }
}