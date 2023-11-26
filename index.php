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
        $products = new ProductController();
        $result = $products->getProduts();

        $result = json_decode($result, true);

	?>
    <div style="height: 100vh;">
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Продукты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Категории</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Княгиня Ольга (продавщица)</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Настройки</a></li>
                                <li><a class="dropdown-item" href="#">Выйти</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container my-4 py-4">
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
                <?php foreach($result as $key => $item): ?>
                <tr>
                    <th scope="row">1</th>
                    <td><?= $item['name'] ?></td>
                    <td><?= (mb_substr($item['description'], 0, 110) . '...') ?></td>
                    <td><?= $item['price'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= $item['category_name'] ?></td>
                    <td scope="col"><a href="#">См. детали...</a></td>
                    <td scope="col">
                        <button type="button" class="btn btn-success my-1">Редактировать</button><br>
                        <button type="button" class="btn btn-danger my-1">Удалить</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <th scope="row">2</th>
                    <td>Хлеб белый</td>
                    <td>Белый хлеб обычно относится к хлебу, приготовленному из пшеничной муки, из которой отруби и зародышевые слои были удалены...</td>
                    <td>49</td>
                    <td>32</td>
                    <td>хлебобулочные изделия</td>
                    <td scope="col"><a href="#">См. детали...</a></td>
                    <td scope="col">
                        <button type="button" class="btn btn-success my-1">Редактировать</button><br>
                        <button type="button" class="btn btn-danger my-1">Удалить</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>