<?php

/**
 * @var mysqli $link
 * @var string $error
 * @var array $categories
 * @var array $lots
 * @var string $page_title
 * @var string $user_name
 */

require_once __DIR__ . '/php/main.php';

if (!is_numeric($_GET['id'])) {
    header('Location: 404.php');
    exit();
}

$id = ($_GET['id']);
$lot = getLot($link, $id);
$error = '';

if (empty($lot['id'])) {
    header('Location: 404.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_data = filterFormFields($_POST);
    $error = validateBetForm($link, $form_data['cost'], $lot);

    if (empty($error)) {
        addBet($link, $_SESSION['user']['id'], $form_data['cost'], $lot['id']);
        header('Location: lot.php?id=' . $lot['id']);
        exit();
    }
}

$bets = getAllBetsOfLot($link, $lot['id']);

$menu = includeTemplate('menu.php', ['categories' => $categories]);

$page_content = includeTemplate('lot-tmp.php', [
    'error' => $error,
    'link' => $link,
    'bets' => $bets,
    'lot' => $lot,
]);

$footer = includeTemplate('footer.php', ['menu' => $menu]);

$layout_content = includeTemplate('layout.php', [
    'menu' => $menu,
    'footer' => $footer,
    'categories' => $categories,
    'page_title' => $page_title . ' | ' . $lot['title'],
    'page_content' => $page_content,
]);

print($layout_content);
