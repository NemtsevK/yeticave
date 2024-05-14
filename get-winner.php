<?php

/**
 * @var $config
 * @var $link
 * @var $user_winner
 */

//use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

//require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/main.php';

$email = $config['email'];

$lots = getLotsWithoutWinner($link);
if (!empty($lots)) {
    foreach ($lots as $lot) {
        $last_bet = getLastBetOfLot($link, $lot['lotId']);
        if (!empty($last_bet)) {
            $winner = addWinner($link, $last_bet['user_id'], $last_bet['lot_id']);
            if (!empty($winner)) {
                $user_winner = getWinner($link, $last_bet['user_id']) ?? null;
            }
            $text_html = includeTemplate('email.php', [
                'lot' => $lot,
                'userWinner' => $user_winner,
            ]);
            try {
                notifyWinner($user_winner, $text_html, $email);
            } catch (TransportExceptionInterface $e) {
            }
        }
    }
}
