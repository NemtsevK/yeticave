<?php

/**
 * Функция проверки формы добавления ставки лота
 * @param mysqli $link Ресурс соединения с базой данных
 * @param string  $form_data Данные из формы лота
 * @param array $lot Массив с данными лота
 * @return string|null Возвращает текст ошибки при наличии
 */
function validateBetForm(mysqli $link, string $form_data, array $lot  ): ?string
{
    $last_bet = getLastBetOfLot($link, $lot['id']);
    $last_bet['price'] = $last_bet['price'] ?? $lot['price'];
    $bet = $last_bet['price'] + $lot['step'];

    if (!empty($last_bet['user_id']) && $last_bet['user_id'] === $_SESSION['user']['id']) {
        $error = 'Последняя ставка сделана текущим пользователем';
    }
    if (strtotime($lot['finish_date']) - time() < 0) {
        $error = 'Срок размещения лота истек';
    }
    if ((!is_numeric($form_data))) {
        $error = 'Введите ставку';
    }
    if ($form_data < $bet) {
        $error = "Ставка должна быть не менее $bet";
    }
    return $error ?? null;
}
