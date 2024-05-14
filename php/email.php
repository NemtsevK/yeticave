<?php

declare(strict_types=1);

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;

/**
 * Функция отправляет сообщение победителю лота
 * @param array $user_winner Данные победителя
 * @param array $email Данные почтового сервера
 * @param string $text_html Сгенерированное сообщение для победителя
 * @return void
 * @throws TransportExceptionInterface
 */
function notifyWinner(array $user_winner, string $text_html, array $email ): void
{
    $transport = Transport::fromDsn('smtp://' . $email['user'] . ':' . $email['password'] . '@' . $email['smtp'] . ':' . $email['port']);
    $mailer = new Mailer($transport);
    $email_send = new Email();

    $email_send->to($user_winner['email']);
    $email_send->from($email['from']);
    $email_send->subject('Hi my friend!');
    $email_send->html($text_html);
    $mailer->send($email_send);
}
