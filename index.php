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

        include_once 'php/ProductController.php';
        $productsObj = new ProductController();
        $products = $productsObj->getProduts();
        $products = json_decode($products, true);

        include_once 'php/CancelTypeController.php';
        $cancelTypeObj = new CancelTypeController();
        $cancelTypes = $cancelTypeObj->getTypes();
        $cancelTypes = json_decode($cancelTypes, true);

        $result['message'] = null;
        if(isset($_POST['cancel_type_change_btn'])) {
            $result = $productsObj->changeProductQuantity();
            $result = json_decode($result, true);
        }

	?>
    <div style="height: 100vh;">
        <?php require_once "header.php"; ?>
        <div class="container my-4 py-4">
            <?php if (!is_null($result['message'])) : ?>
                <div class="alert alert-danger" role="alert"><?= $result['message'] ?></div>
            <?php endif; ?>
            <table class="table">
                <thead>
                    <tr class="table-primary">
                        <th scope="col">#</th>
                        <th scope="col">Название товара</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Текущая цена</th>
                        <th scope="col">Количество</th>
                        <th scope="col">Категория</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($products as $key => $item): ?>
                <tr>
                    <th scope="row"><?= $key ?></th>
                    <td><?= $item['name'] ?></td>
                    <td><?= (mb_substr($item['description'], 0, 110) . '...') ?></td>
                    <td><?= $item['price'] . ' руб.' ?></td>
                    <td>
                        <input type="number" class="form-control" id="quantity_input" min="0" value=<?= $item['quantity'] ?? 0 ?> onchange="changeQuantity()" onclick="changeQuantity()">
                        <input type="hidden" class="form-control" id="product_id_input" value=<?= $item['id'] ?? 0 ?>>
                        <button type="button" class="btn btn-success my-1" data-bs-toggle="modal" data-bs-target="#cancel-type">Изменить</button><br>
                    </td>
                    <td><?= $item['category_name'] ?></td>
                    <td scope="col"><a href="/product_details.php?id=<?=$item['id']?>">См. детали...</a></td>
                    <td scope="col">
                        <button type="button" class="btn btn-success my-1">Редактировать</button><br>
                        <button type="button" class="btn btn-danger my-1">Удалить</button>
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
    <script>
        function changeQuantity() {
            document.getElementById("quantity").value = document.getElementById("quantity_input").valueAsNumber;
            document.getElementById("product_id").value = document.getElementById("product_id_input").value;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>