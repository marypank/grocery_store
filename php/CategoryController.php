<?php

class CategoryController
{
    private $connection;

    public function __construct()
    {
        require "dbConnection.php";
        $this->connection = $connection;
    }

    public function getCategories()
    {
        $query = $this->connection->prepare("SELECT * FROM `categories`");
        $query->execute();
        $result = $query->get_result();
        
        $result = $result->fetch_all(MYSQLI_ASSOC);

        return json_encode($result);
    }
}