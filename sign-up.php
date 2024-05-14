<?php

/**
 * @var array $categories
 * @var string $user_name
 * @var string $page_title
 * @var mysqli $link Ресурс соединения с базой данных
 * @var array $page_content
 */

require __DIR__ . '/php/main.php';

if (isset($_SESSION['user'])) {
    header('Location: 403.php');
}

$errors = [];
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_data = filterFormFields($_POST);
    $errors = validateRegistrationForm($link, $form_data);
    if (!($errors)) {
        $form_data['password'] = password_hash(($form_data["password"] ?? ''), PASSWORD_DEFAULT);
        addUser($link, $form_data);
        header("Location: login.php");
        die();
    }
}

$menu = includeTemplate('menu.php', ['categories' => $categories]);

$page_content = includeTemplate('sign.php', [
    'categories' => $categories,
    'form_data' => $form_data,
    'errors' => $errors,
]);

$footer = includeTemplate('footer.php', ['menu' => $menu]);

$layout_content = includeTemplate('layout.php', [
    'menu' => $menu,
    'footer' => $footer,
    'categories' => $categories,
    'page_title' => $page_title . '| Регистрация',
    'page_content' => $page_content,
]);

print($layout_content);
