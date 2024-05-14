<?php

/**
 * @var array $categories
 * @var string $page_title
 * @var string $user_name
 */

require_once __DIR__ . '/php/main.php';

header("HTTP/1.1 403 Forbidden");
header("Status: 403 Forbidden");

$menu = includeTemplate('menu.php', ['categories' => $categories]);

$page_content = includeTemplate('403-error.php');

$footer = includeTemplate('footer.php', ['menu' => $menu]);

$layout_content = includeTemplate('layout.php', [
    'footer' => $footer,
    'menu' => $menu,
    'page_title' => $page_title . ' | 403',
    'page_content' => $page_content,
]);

print($layout_content);
