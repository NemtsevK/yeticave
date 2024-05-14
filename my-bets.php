<?php
/**
 * @var $menu
 * @var $categories
 * @var $link
 * @var $page_title
 * @var $time_left
 * @var $contact
 */

require_once __DIR__ . '/php/main.php';

$user_id = getUserIdFromSession();
$bets = getAllMyBets($link, $user_id);
$contact = getUserContactById($link, $user_id);

$menu = includeTemplate('menu.php', ['categories' => $categories]);

$page_content = includeTemplate('bets-tmp.php', [
    'bets' => $bets,
    'user_id' => $user_id,
    'contact' => $contact,
]);

$footer = includeTemplate('footer.php', ['menu' => $menu]);

$layout_content = includeTemplate('layout.php', [
    'menu' => $menu,
    'footer' => $footer,
    'categories' => $categories,
    'page_title' => $page_title . ' | Мои ставки',
    'page_content' => $page_content,
]);

print($layout_content);
