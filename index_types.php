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

    include_once 'php/CancelTypeController.php';
    $typesObj = new CancelTypeController();
    $types = $typesObj->getTypes();
    $types = json_decode($types, true);

    if (isset($_POST['change_name_btn'])) {
        $result = $typesObj->update();
        $result = json_decode($result, true);
    }

    if (isset($_POST['create_name_btn'])) {
        $result = $typesObj->create();
        $result = json_decode($result, true);
    }

    $id = $_GET['cancel_type_id_del'] ?? 0;
    if (isset($_GET['delete_type_btn']) && $id) {
        $result = $typesObj->delete((int)$id);
        $result = json_decode($result, true);
    }

    ?>
    <div style="height: 100vh;">
        <?php require_once "header.php"; ?>
        <div class="container my-4 py-4">
            <?php if (!is_null($result['message'])) : ?>
                <div class="alert alert-danger" role="alert"><?= $result['message'] ?></div>
            <?php endif; ?>
            <button type="button" data-bs-toggle="modal" data-bs-target="#create-category" class="btn btn-success my-2">Создать тип списания</button>
            <table class="table">
                <thead>
                <tr class="table-primary">
                    <th scope="col">#</th>
                    <th scope="col">Название типа списания</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($types as $key => $item): ?>
                    <tr class="trs">
                        <td><?= $key ?></td>
                        <td><?= $item['name'] ?></td>
                        <td>
                            <input type="hidden" name="type_id" class="type_id" value="<?= $item['id'] ?>">
                            <button type="button" class="btn btn-success my-1 update_btn" data-bs-toggle="modal" data-bs-target="#change-name">Редактировать</button>
                        </td>
                        <td>
                            <input type="hidden" class="type_id_del" name="type_id_del" id="type_id_del" value="<?= $item['id'] ?>">
                            <button type="button" class="btn btn-danger my-1 delete_btn" name="delete_btn" id="delete_btn"  data-bs-toggle="modal" data-bs-target="#delete-type">Удалить</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="modal fade" id="change-name" tabindex="-1" aria-labelledby="change-name-label" aria-hidden="true">
                <form action="" method="POST" name="change_name_form">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="change-name-label">Обновить тип списания</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="cancel_type_id" name="cancel_type_id">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Название</label>
                                    <input type="text" class="form-control" name="new_name" id="new_name" minlength="2" maxlength="256" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                                <button type="submit" class="btn btn-primary" name="change_name_btn" value="change_name_btn">Сохранить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal fade" id="create-category" tabindex="-1" aria-labelledby="create-category-label" aria-hidden="true">
                <form action="" method="POST" name="create_category_form">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="change-name-label">Создать тип списания</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Название</label>
                                    <input type="text" class="form-control" name="name" id="name" minlength="2" maxlength="256" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                                <button type="submit" class="btn btn-primary" name="create_name_btn" value="create_name_btn">Сохранить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal fade" id="delete-type" tabindex="-1" aria-labelledby="delete-type-label" aria-hidden="true">
                <form action="" method="GET" name="delete_type_form">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="delete-type-label">Подтверждение удаления типа списания</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="cancel_type_id_del" name="cancel_type_id_del">
                                <p>Вы уверены, что хотите удалить данный тип списания? Это приведет к неточностям в отчетах о продуктах, если данный тип списания был когда-то выбран.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                                <button type="submit" class="btn btn-primary" name="delete_type_btn" value="delete_type_btn">Удалить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $( ".update_btn" ).on( "click", function(item) {
            let typeId = $(this).siblings('.type_id').val();

            $("#cancel_type_id").val(typeId);
        });

        $( ".delete_btn" ).on( "click", function(item) {
            let typeId = $(this).siblings('.type_id_del').val();
            console.log(typeId)

            $("#cancel_type_id_del").val(typeId);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>
</html>