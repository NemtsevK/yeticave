<?php

/**
 * @var $link
 * @var $config
 * @var $message
 * @var array $categories
 * @var  $page_title
 * @var  $user_name
 */

require_once __DIR__ . "/php/main.php";

$lots_per_page = $config['pagination']['lots_per_page'];
$message = 'Все лоты категории ';

if (!in_array($_GET['id'], array_column($categories, 'id'))) {
    header('Location: 404.php');
}
$category = $_GET['id'];
$current_page_number = getCurrentPageNumber($_GET);
$items_count = getCountTotalLotsInCategory($link, $category);
$total_pages_count = getTotalPagesCount($items_count, $lots_per_page);
$lots = getLotsByCategory($link, $category, $lots_per_page, $current_page_number);
$get_param = '&id=' . $category;

$menu = includeTemplate('menu.php', ['categories' => $categories]);

$pagination = includeTemplate('pagination.php', [
    'lots_per_page' => $lots_per_page,
    'items_count' => $items_count,
    'current_page_number' => $current_page_number,
    'total_pages_count' => $total_pages_count,
    'lots' => $lots,
    'get_param' => $get_param,
]);

$page_content = includeTemplate('lots.php', [
    'pagination' => $pagination,
    'lots' => $lots,
    'message' => $message,
    'link' => $link,
    'category' => $category,
]);
$footer = includeTemplate('footer.php', ['menu' => $menu]);
$layout_content = includeTemplate('layout.php', [
    'menu' => $menu,
    'footer' => $footer,
    'page_title' => $page_title . ' | ' . getCategoryNameById($link, $category),
    'page_content' => $page_content,
]);

print ($layout_content);
