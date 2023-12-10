<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Магазин "Продукты 364 дня"</title>
</head>
<body>
    <?php
    if(session_id() == '') {
        session_start();
    }
    if (!isset($_SESSION['store_login'])) {
        header('Location: login.php');
    }
    if ($_SESSION['store_access'] == 0) {
        header('Location: index.php');
    }

    $result['message'] = null;

    if (!isset($_GET['start_date_quant']) || !isset($_GET['end_date_quant'])) {
        header('Location: index_reports.php');
    }

    include "php/ReportController.php";
    $reportObj = new ReportController();
    $response = $reportObj->getQuantityReport($_GET['start_date_quant'], $_GET['end_date_quant']);

    ?>
    <div style="height: 100vh;">
        <div class="container my-4 py-4">
            <?php if (!is_null($result['message'])) : ?>
                <div class="alert alert-danger" role="alert"><?= $result['message'] ?></div>
            <?php endif; ?>
            <table class="table">
                <thead>
                <tr class="table-primary">
                    <th scope="col">#</th>
                    <th scope="col">Название товара</th>
                    <th scope="col">Разница в количестве</th>
                    <th scope="col">Тип списания</th>
                    <th scope="col">Кто провел операцию</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Статус продукта</th>
                </tr>
                </thead>
                <tbody>
                <?php $keyCount = 0;
                    foreach($response as $key => $itemMain): ?>
                    <?php $keyCount++;
                        foreach($itemMain as $keyId => $item): ?>
                        <tr>
                            <th scope="row"><?= $keyCount ?></th>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['quantityDiff'] ?></td>
                            <td><?= $item['cancelType'] ?></td>
                            <td><?= $item['who'] ?></td>
                            <td><?= $item['date'] ?></td>
                            <td><?= $item['has'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>
</html>