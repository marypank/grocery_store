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
            header('Location: index.php');
        }
        if ($_SESSION['store_access'] == 0) {
            header('Location: index.php');
        }

        $result = [
            'success' => true,
            'message' => null,
            'data' => [
                'login' => null,
                'password' => null,
            ],
        ];

        if(isset($_POST['register_btn'])) {
            include_once 'php/UserController.php';
            $user = new UserController();
            $result = $user->register();
        }
    ?>
    <div style="height: 100vh;">
        <?php require_once "header.php"; ?>
        <div class="container my-4 py-4">
            <?php if (!is_null($result['message'])) : ?>
                <div class="alert alert-danger" role="alert"><?= $result['message'] ?></div>
            <?php endif; ?>
            <div class="row h-100 d-flex align-items-center justify-content-center">
                <div class="col"></div>
                <div class="col-4">
                    <form action="" method="POST">
                        <h2>Создание пользователя</h2>
                        <?php if (!$result['success']) : ?>
                            <div class="alert alert-danger" role="alert"><?= $result['message'] ?></div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="login" class="form-label">Логин</label>
                            <input type="text" class="form-control" id="login" name="login" required minlength="2" maxlength="64" value=<?= $result['data']['login'] ?? '' ?>>
                        </div>
                        <div class="mb-3">
                            <label for="fio" class="form-label">ФИО</label>
                            <input type="text" class="form-control" id="fio" name="fio" required minlength="15" maxlength="256" value=<?= $result['data']['login'] ?? '' ?>>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password" required minlength="4" maxlength="25">
                        </div>
                        <button type="submit" class="btn btn-primary" name="register_btn" value="register_btn">Создать</button>
                    </form>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>
</html>