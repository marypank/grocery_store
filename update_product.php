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

        $id = $_GET['id'];
        include_once 'php/ProductController.php';
        $productsObj = new ProductController();
        $products = $productsObj->getProductDetails((int)$id);
        $product = json_decode($products, true);
        $product = current($product);

        include_once 'php/CancelTypeController.php';
        $cancelTypeObj = new CancelTypeController();
        $cancelTypes = $cancelTypeObj->getTypes();
        $cancelTypes = json_decode($cancelTypes, true);

        include_once 'php/CategoryController.php';
        $categoriesObj = new CategoryController();
        $categories = $categoriesObj->getCategories();
        $categories = json_decode($categories, true);

        $result['message'] = null;
        if(isset($_POST['update_btn'])) {
            $result = $productsObj->update();
            $result = json_decode($result, true);

            if (is_null($result['message'])) {
                header("Refresh:0");
            }
        }

	?>
    <div style="height: 100vh;">
        <?php require_once "header.php"; ?>
        <div class="container my-4 py-4">
            <?php if (!is_null($result['message'])) : ?>
                <div class="alert alert-danger" role="alert"><?= $result['message'] ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <h2>Обновление товара/продукта</h2>
                <input type="hidden" id="product_id" name="product_id" value="<?= $product["id"] ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Название</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?= $product["name"] ?>" minlength="10" maxlength="400" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Цена</label>
                    <input type="text" class="form-control" name="price" id="price" value="<?= $product["price"] ?>">
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Количество</label>
                    <input type="hidden" class="form-control" id="initial_quantity" value="<?= $product["quantity"] ?>">
                    <input type="number" class="form-control" name="quantity" id="quantity" value="<?= $product["quantity"] ?>" onchange="changeQuantity()" onclick="changeQuantity()">
                </div>
                <div class="mb-3 cancelTypeBlock" hidden>
                    <label for="cancel_type_id" class="form-label">Причина увеличения/уменьшения количества товара</label>
                    <select class="form-select selectCancelType" aria-label="cancel_type_select" name="cancel_type_id" id="cancel_type_id" disabled>
                        <?php foreach($cancelTypes as $key => $item): ?>
                            <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Категория</label>
                    <select class="form-select" name="category_id" required>
                        <?php foreach($categories as $key => $category): ?>
                        <option value="<?= $category['id'] ?>" <?php if ($product['id_category'] == $category['id']) { echo 'selected'; } ?>><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Описание</label>
                    <textarea class="form-control" name="description" rows="3" id="description"><?= $product['description'] ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="update_btn" id="update_btn">Обновить</button>
            </form>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        let initialQuantityValue = $("#initial_quantity").val();
        function changeQuantity() {
            if ($("#quantity").val() != initialQuantityValue) {
                let cancelTypeBlock = $(".cancelTypeBlock");
                cancelTypeBlock.attr('hidden', false);
                cancelTypeBlock.attr('required', true);

                let selectCancelType = $(".selectCancelType");
                selectCancelType.attr('disabled', false);
            } else {
                let cancelTypeBlock = $(".cancelTypeBlock");
                cancelTypeBlock.attr('hidden', true);
                cancelTypeBlock.attr('required', false);

                let selectCancelType = $(".selectCancelType");
                selectCancelType.attr('disabled', true);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    </body>
</html>