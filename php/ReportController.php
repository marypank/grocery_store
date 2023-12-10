<?php

class ReportController
{
    private $connection;

    public const OP_TYPES = [
        'CREATE' => 'Создание товара',
        'UPDATE' => 'Изменение товара',
        'DELETE' => 'Удаление товара',
    ];

    public function __construct()
    {
        require "dbConnection.php";
        $this->connection = $connection;

        require "ProductController.php";
    }

    public function getQuantityReport($dateStart, $dateEnd)
    {
        $response = [];

        $query = $this->connection->prepare("SELECT * FROM products_quantity_his pqh LEFT JOIN products pd on pqh.product_id = pd.id WHERE date_stamp BETWEEN ? and ? ORDER BY date_stamp;");
        $query->bind_param('ss', $dateStart, $dateEnd);
        $query->execute();
        $result = $query->get_result();
        $result = $result->fetch_all(MYSQLI_ASSOC);


        foreach ($result as $item) {
            if ($item['op_type'] === ProductController::CREATE_OPERATION_TYPE) {
                $quantityDiff = 0;
            } else {
                $oldVal = (int) $item['old_val'];
                $newVal = (int) $item['new_val'];
                $quantityDiff = $oldVal > $newVal ? $oldVal - $newVal : $newVal - $oldVal;
            }

            if ($item['op_type'] === ProductController::DELETE_OPERATION_TYPE && is_null($item['id'])) { // Удаленный продукт
                $response[$item['product_id']][] = [
                    'name' => $item['product_name'],
                    'quantityDiff' => $quantityDiff,
                    'cancelType' => $item['cancel_type_text'],
                    'who' => $item['who'],
                    'has' => 'Удален',
                    'date' => $item['date_stamp']
                ];
            }
            if ($item['id'] == $item['product_id']) {
                $response[$item['id']][] = [
                    'name' => $item['name'],
                    'quantityDiff' => $quantityDiff,
                    'cancelType' => $item['cancel_type_text'],
                    'who' => $item['who'],
                    'has' => 'В наличии',
                    'date' => $item['date_stamp']
                ];
            }
        }

        return $response;
    }
}