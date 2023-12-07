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
            
        $id = $_GET['id'] ?? $_GET['product_id'] ?? -1;
        if ($id < 0) {
            header('Location: ../index.php');
        }
        include_once 'php/ProductController.php';
        $productsObj = new ProductController();
        $products = $productsObj->getProductDetails((int)$id);
        $product = json_decode($products, true);
        $product = current($product);

        include_once 'php/CancelTypeController.php';
        $cancelTypeObj = new CancelTypeController();
        $cancelTypes = $cancelTypeObj->getTypes();
        $cancelTypes = json_decode($cancelTypes, true);

        $result['message'] = null;
        if(isset($_POST['cancel_type_change_btn'])) {
            $result = $productsObj->changeProductQuantity();
            $result = json_decode($result, true);
            if (is_null($result['message'])) {
                header("Refresh:0");
            }
        }

        if (isset($_GET['delete_btn'])) {
            $result = $productsObj->delete((int)$id);
        }

	?>
    <div style="height: 100vh;">
        <?php require_once "header.php"; ?>
        <div class="container my-4 py-4">
            <?php if (!is_null($result['message'])) : ?>
                <div class="alert alert-danger" role="alert"><?= $result['message'] ?></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <p class="card-text">Описание: <?= $product['description'] ?></p>
                    <ul class="list-group list-group-flush" style="width: 50%;">
                        <li class="list-group-item">Цена: <?= $product['price'] ?> руб</li>
                        <li class="list-group-item" style="width: 50%;">Количество:
                            <input type="number" class="form-control" id="quantity_input" min="0" value=<?= $product['quantity'] ?? 0 ?> onchange="changeQuantity()" onclick="changeQuantity()">
                            <input type="hidden" class="form-control" id="product_id_input" value=<?= $product['id'] ?? 0 ?>>
                            <button type="button" class="btn btn-success my-1" data-bs-toggle="modal" data-bs-target="#cancel-type">Изменить</button><br>
                        </li>
                        <li class="list-group-item">Категория: <?= $product['category_name'] ?></li>
                    </ul>
                    <a class="btn btn-success my-1" href="/update_product.php?id=<?=$product['id']?>" role="button">Редактировать</a>
                    <form name="delete_product_form" action="" method="GET">
                        <input type="hidden" name="product_id" id="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" class="btn btn-danger my-1" name="delete_btn" id="delete_btn">Удалить</button>
                    </form>
                </div>
            </div>

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
                            <input type="hidden" name="product_id" id="product_id" value="<?= $product['id'] ?>">
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