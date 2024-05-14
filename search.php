<?php

/**
 * @var array $config
 * @var array $categories
 * @var string $page_title
 * @var  mysqli $link
 */

require_once __DIR__ . "/php/main.php";

if (empty($_GET['search'])) {
    $message = 'Введите запрос в строку поиска';
}

$lots_per_page = $config['pagination']['lots_per_page'];
$message = 'Результаты поиска по запросу ';

$search = filterSearchForm($_GET);
$current_page_number = getCurrentPageNumber($_GET);
$items_count = getCountTotalFoundLotsFromSearch($link, $search);
$total_pages_count = getTotalPagesCount($items_count, $lots_per_page);
$lots = searchLots($link, $search, $lots_per_page, $current_page_number);
$get_param = '&search=' . $search;

if (!empty($search) && $items_count === 0) {
    $message = 'Ничего не найдено по запросу ';
}

$menu = includeTemplate('menu.php', ['categories' => $categories]);

$pagination = includeTemplate('pagination.php', [
    'lots_per_page' => $lots_per_page,
    'items_count' => $items_count,
    'current_page_number' => $current_page_number,
    'search' => $search,
    'total_pages_count' => $total_pages_count,
    'get_param' => $get_param,
]);

$page_content = includeTemplate('search-tmp.php', [
    'pagination' => $pagination,
    'message' => $message,
    'search' => $search,
    'categories' => $categories,
    'lots' => $lots,
]);

$footer = includeTemplate('footer.php', ['menu' => $menu]);

$layout_content = includeTemplate('layout.php', [
    'menu' => $menu,
    'footer' => $footer,
    'categories' => $categories,
    'page_title' => $page_title,
    'page_content' => $page_content,
]);

print ($layout_content);
