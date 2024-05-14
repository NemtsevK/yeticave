<?php

/** @var array $categories
 * @var array $lots
 * @var string $page_title
 * @var string $user_name
 * @var mysqli $link
 */

require_once __DIR__ . '/php/main.php';

$user_id = getUserIdFromSession();

$errors = [];
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_data = getLotFormData($_POST);
    $errors = validateLotForm($form_data, $_FILES);

    if (empty($errors)) {
        $form_data['image'] = uploadFile($_FILES);
        $form_data['user_id'] = $user_id;
        $id = addLot($link, $form_data);
        header("Location: lot.php?id=$id");
        exit();
    }
}

$menu = includeTemplate('menu.php', ['categories' => $categories]);

$page_content = includeTemplate('add-lot.php', [
    'categories' => $categories,
    'errors' => $errors,
    'form_data' => $form_data,
]);

$footer = includeTemplate('footer.php', ['menu' => $menu]);

$layout_content = includeTemplate('layout.php', [
    'menu' => $menu,
    'footer' => $footer,
    'page_title' => $page_title . '| Добавить лот',
    'page_content' => $page_content,
]);

print($layout_content);
