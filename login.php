<?php

/**
 * @var array $categories
 * @var string $user_name
 * @var array $users
 * @var array $form_data
 * @var mysqli $link
 * @var string $page_title
 */

require_once __DIR__ . '/php/main.php';

$form_data = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_data = filterFormFields($_POST);
    $errors = validateLoginForm($link, $form_data);
    $user = getUserByEmail($link, $form_data['email']);

    if (empty($errors)) {
        $_SESSION['user'] = getUserByEmail($link, $form_data['email']);
        header('Location: index.php');
        exit();
    }
}
$menu = includeTemplate('menu.php', ['categories' => $categories]);

$page_content = includeTemplate('login-tmp.php', [
    'categories' => $categories,
    'form_data' => $form_data,
    'errors' => $errors,
]);
$footer = includeTemplate('footer.php', ['menu' => $menu]);
$layout_content = includeTemplate('layout.php', [
    'footer' => $footer,
    'menu' => $menu,
    'page_content' => $page_content,
    'page_title' => $page_title . ' | Вход',
]);

print($layout_content);
