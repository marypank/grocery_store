<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/index.php">Продукты</a>
                </li>
                <?php if ($_SESSION['store_access'] == 1) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/index_categories.php">Категории</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/index_types.php">Типы списания</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $_SESSION['store_login'] . '('. $_SESSION['store_name'] . ')' ?></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <?php if ($_SESSION['store_access'] == 1) : ?>
                            <li><a class="dropdown-item" href="/index_users.php">Пользователи</a></li>
                            <li><a class="dropdown-item" href="/index_reports.php">Отчеты</a></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="/php/logOut.php">Выйти</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>