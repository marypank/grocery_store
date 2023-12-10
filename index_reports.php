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
    $result['message'] = null;


    if (isset($_GET['quant_report'])) {
        if ($_GET['start_date_quant'] > $_GET['end_date_quant']) {
            $result['message'] = 'Дата начала должна быть меньше даты конца отчета';
        } else {
            header('Location: report_products_and_types.php?' . http_build_query($_GET) );
        }
    }

    ?>
    <div style="height: 100vh;">
        <?php require_once "header.php"; ?>
        <div class="container my-4 py-4">
            <?php if (!is_null($result['message'])) : ?>
                <div class="alert alert-danger" role="alert"><?= $result['message'] ?></div>
            <?php endif; ?>

            <div class="card" style="width: 25rem;">
                <div class="card-body">
                    <h5 class="card-title">Отчет о товарах и типах списания</h5>
                    <form action="" method="GET" name="report_quant_form">
                        <div class="mb-3 form-check">
                            <label for="start_date_quant" class="form-label">Дата начала</label>
                            <input type="date" class="form-control" id="start_date_quant" name="start_date_quant" required>
                        </div>
                        <div class="mb-3 form-check">
                            <label for="end_date_quant" class="form-label">Дата конца</label>
                            <input type="date" class="form-control" id="end_date_quant" name="end_date_quant" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="quant_report" value="quant_report">Сформировать</button>
                    </form>
                </div>
            </div>

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