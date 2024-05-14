<?php

/**
 * @var $categories
 * @var $page_title
 * @var $user_name
 */

require_once __DIR__ . '/php/main.php';

header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");

$menu = includeTemplate('menu.php', ['categories' => $categories]);

$page_content = includeTemplate('404-error.php');

$footer = includeTemplate('footer.php', ['menu' => $menu]);

$layout_content = includeTemplate('layout.php', [
    'footer' => $footer,
    'menu' => $menu,
    'page_title' => $page_title . ' | 404',
    'page_content' => $page_content,
]);
print($layout_content);
