<?php
/**
 * @var $page_title
 * @var $user_name
 * @var $page_content
 * @var $categories
 * @var $footer
 */
?>

<!DOCTYPE html>
<html class="page" lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?></title>
    <link rel="icon" href="favicon.ico">
    <link rel="icon" href="images/favicons/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="images/favicons/apple.png">
    <link rel="manifest" href="manifest.webmanifest">
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/flatpickr.min.css" rel="stylesheet">
</head>
<body class="page__body">
<div class="page-wrapper">

    <header class="main-header">
        <div class="main-header__container container">
            <h1 class="visually-hidden">YetiCave</h1>
            <a class="main-header__logo" href="index.php">
                <img src="images/logo.svg" width="160" height="39" alt="Логотип компании YetiCave">
            </a>
            <form class="main-header__search" method="get" action="search.php" autocomplete="off">
                <label>
                    <input type="search" name="search" placeholder="Поиск лота">
                </label>
                <input class="main-header__search-btn" type="submit" name="find" value="Найти">
            </form>
            <a class="main-header__add-lot button" href="add.php">Добавить лот</a>

            <nav class="user-menu">
                <?php if (!empty($_SESSION['user'])): ?>
                    <div class="user-menu__logged">
                        <p><?= $_SESSION['user']['name'] ?></p>
                        <a class="user-menu__bets" href="my-bets.php">Мои ставки</a>
                        <a class="user-menu__logout" href="logout.php">Выход</a>
                    </div>
                <?php else: ?>
                    <ul class="user-menu__list">
                        <li class="user-menu__item">
                            <a href="sign-up.php">Регистрация</a>
                        </li>
                        <li class="user-menu__item">
                            <a href="login.php">Вход</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <?= $menu ?? '' ?>

    <main class="container">

        <?= $page_content ?>

    </main>
</div>

<?= $footer ?>

<script src="js/flatpickr.js"></script>
<script src="js/script.js"></script>
</body>
</html>
