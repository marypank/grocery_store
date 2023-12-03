<?php

class CancelTypeController
{
    public function getTypes()
    {
        require "dbConnection.php";
        $query = $connection->prepare("SELECT * FROM `cancel_type`");
        $query->execute();
        $result = $query->get_result();
        
        $result = $result->fetch_all(MYSQLI_ASSOC);

        return json_encode($result);
    }
}