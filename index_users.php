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

        include_once 'php/UserController.php';
        $usersObj = new UserController();
        $users = $usersObj->getAllUsers();
        $users = json_decode($users, true);

        $id = $_GET['del_user_id'] ?? 0;
        if (isset($_GET['delete_btn']) && $id) {
            $result = $usersObj->deleteUser((int)$id);
            $result = json_decode($result, true);
            if (is_null($result['message'])) {
                header('Location: index_users.php');
            }
        }

        if (isset($_POST['change_access_btn'])) {
            $result = $usersObj->changeAccess();
            $result = json_decode($result, true);
        }

    ?>
    <div style="height: 100vh;">
        <?php require_once "header.php"; ?>
        <div class="container my-4 py-4">
            <?php if (!is_null($result['message'])) : ?>
                <div class="alert alert-danger" role="alert"><?= $result['message'] ?></div>
            <?php endif; ?>
            <a href="/register.php" class="btn btn-success my-2">Создать пользователя</a>
            <table class="table">
                <thead>
                <tr class="table-primary">
                    <th scope="col">#</th>
                    <th scope="col">Логин</th>
                    <th scope="col">ФИО</th>
                    <th scope="col">Админ доступ</th>
                    <th scope="col">Сменить тип доступа</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($users as $key => $item): ?>
                    <tr>
                        <th scope="row"><?= $key ?></th>
                        <td><?= $item['user_name'] ?></td>
                        <td><?= $item['full_name'] ?></td>
                        <td><?= $item['access'] ? 'Да' : 'Нет' ?></td>
                        <td>
                            <form name="change_access" action="" method="POST">
                                <input type="hidden" name="access" id="access" value="<?= $item['access'] ?>">
                                <input type="hidden" name="user_id" id="user_id" value="<?= $item['id'] ?>">
                                <button type="submit" class="btn btn-<?= $item['access'] ? 'danger' : 'success' ?> my-1" name="change_access_btn" id="change_access_btn"><?= $item['access'] ? 'Снять права' : 'Получить права' ?></button>
                            </form>
                        </td>
                        <td>
                            <form name="delete_user_form" action="" method="GET">
                                <input type="hidden" name="del_user_id" id="del_user_id" value="<?= $item['id'] ?>">
                                <button type="submit" class="btn btn-danger my-1" name="delete_btn" id="delete_btn">Удалить</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="modal fade" id="cancel-type" tabindex="-1" aria-labelledby="cancel-type-label" aria-hidden="true">
                <form action="" method="POST" name="cancel_type_change_form">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cancel-type-label">Причина увеличения/уменьшения количества товара</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <select class="form-select" aria-label="cancel_type_select" name="cancel_type_id">
                                    <?php foreach($cancelTypes as $key => $item): ?>
                                        <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" id="quantity" name="quantity">
                                <input type="hidden" id="product_id" name="product_id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                                <button type="submit" class="btn btn-primary" name="cancel_type_change_btn" value="cancel_type_change_btn">Сохранить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(".change_quant_btn" ).on( "click", function() {
            let quantity_input = $(this).siblings('.quantity_input').val();
            $("#quantity").val(quantity_input);

            let id = $(this).siblings('.product_id_input').val();
            $("#product_id").val(id);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>
</html>