<?php

/**
 * @var $link
 * @var $config
 * @var $page_title
 * @var $user_name
 * @var $categories
 * @var $lots
 * @var $promo_menu
 * @var $menu
 * @var $lots_per_page
 */

require_once __DIR__ . '/php/main.php';
require_once __DIR__ . '/get-winner.php';

$lots_per_page = $config['pagination']['mainLotsPage'];

$current_page_number = getCurrentPageNumber($_GET);
$items_count = getCountLotsOpened($link);
$total_pages_count = getTotalPagesCount($items_count, $lots_per_page);
$lots = getLots($link, $lots_per_page, $current_page_number);

$menu = includeTemplate('menu.php', ['categories' => $categories]);
$promo_menu = includeTemplate('promo_menu.php', ['categories' => $categories]);
$lots_list = includeTemplate('lots-list.php', [
    'lots' => $lots,
    'link' => $link,
]);

$pagination = includeTemplate('pagination.php', [
    'total_pages_count' => $total_pages_count,
    'current_page_number' => $current_page_number,
]);

$page_content = includeTemplate('main.php', [
    'promo_menu' => $promo_menu,
    'lots_list' => $lots_list,
    'pagination' => $pagination,
]);

$footer = includeTemplate('footer.php', ['categories' => $categories, 'menu' => $menu]);

$layout_content = includeTemplate('layout.php', [
    'footer' => $footer,
    'page_title' => $page_title . ' | Главная',
    'page_content' => $page_content,
]);
print($layout_content);
