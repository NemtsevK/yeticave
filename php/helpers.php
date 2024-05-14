<?php

/**
 * Функция подсчета общего количества в пагинации
 * @param int $items_count
 * @param int $lots_per_page
 * @return int Возвращает общее количество страницы в пагинации
 */

function getTotalPagesCount(int $items_count, int $lots_per_page): int
{
    return (int)ceil($items_count / $lots_per_page);
}

/**
 * Функция загружает файл в папку 'uploads/' и возвращает ссылку на загруженный файл
 * @param array $file Массив с данными о файле
 * @return string Если файл успешно загружен, возвращает ссылку на загруженный файл
 */
function uploadFile(array $file): string
{
    $path = '';
    if (!empty($file['image']['name'])) {
        $file_name = $file['image']['name'];
        $file_temp = $file['image']['tmp_name'];
        $file_path = UPLOAD_DIR . '/' . $file_name;
        $file_status = move_uploaded_file($file_temp, $file_path);

        if ($file_status) {
            $path = 'uploads/' . $file_name;
        } else {
            exit('При загрузке файла, произошла критическая ошибка');
        }
    }
    return $path;
}

/**
 * Функция фильтрации данных из формы добавления лота
 * @param array $data Данные из формы
 * @return array Возвращает отфильтрованный массив с данными
 */

function getLotFormData(array $data): array
{
    $form_data = filterFormFields($data);

    $form_data['category_id'] = (int)$data['category_id'];
    $form_data['price'] = (int)$data['price'];
    $form_data['step'] = (int)$data['step'];

    return $form_data;
}

/**
 * Функция фильтрации данных из формы добавления лота
 * @param array $data Данные из формы
 * @return array Возвращает отфильтрованный массив с данными
 */

function filterFormFields(array $data): array
{
    $data_filter = [];
    foreach ($data as $key => $val) {
        $data_filter[$key] = htmlspecialchars($val, ENT_QUOTES);
    }
    return $data_filter;
}

/**
 * Функция фильтрации поля поиска
 * @param array $data Данные из формы поиска
 * @return string Возвращает отфильтрованную строку поля поиска
 */

function filterSearchForm(array $data): string
{
    $data = filterFormFields($data);
    return trim($data['search']);
}

/**
 * Функция возвращает номер текущей страницы
 * @param array $data Данные из GET параметров
 * @return int При отсутствии номера возвращает по умолчанию 1
 */

function getCurrentPageNumber(array $data): int
{
    return !empty($data['page']) ? (int)$data['page'] : 1;
}

/**
 * Функция возвращает оставшееся время до окончания размещения лота от текущего времени
 * @param string $finish_date Дата окончания размещения лота
 * @return array Возвращает массив [часы, минуты]
 */

function timeLeft(string $finish_date): array
{
    $time = [];
    $diff = strtotime($finish_date) - time();
    if ($diff <= 0) {
        $time = ['00', '00'];
    } else {
        $time[] = str_pad(floor($diff / 3600), 2, "0", STR_PAD_LEFT);
        $time[] = str_pad(floor(($diff % 3600) / 60), 2, "0", STR_PAD_LEFT);
    }
    return $time;
}

/**
 * Функция возвращает цену удобочитаемом формате
 * @param int $price Цена лота
 * @return string Строка в заданном формате
 */

function priceFormat(int $price): string
{
    return number_format(ceil($price), 0, '', ' ') . ' ₽';
}

/**
 * Функция возвращает строку с названием класса для подстановки в шаблон
 * @param string $finish_date Дата окончания размещения лота
 * @param int $Id Идентификатор пользователя
 * @param ?int $winner_id Идентификатор победителя, при наличии
 * @return ?string
 */

function timerClass(string $finish_date, int $Id, ?int $winner_id): ?string
{

    if ($Id === $winner_id) {
        $timer_class = 'timer--win';
    } elseif (strtotime($finish_date) <= time()) {
        $timer_class = 'timer--end';
    } elseif ((int)timeLeft($finish_date)[0] < 1) {
        $timer_class = 'timer--finishing';
    } else {
        $timer_class = '';
    }
    return $timer_class;
}

/**
 * Функция возвращает строку с названием класса для подстановки в шаблон
 * @param string $finish_date Дата окончания размещения лота
 * @param int $Id Идентификатор пользователя
 * @param ?int $winner_id Идентификатор победителя, при наличии
 * @return string | null
 */

function ratesItemClass(string $finish_date, int $Id, ?int $winner_id): ?string
{
    if ($Id === $winner_id) {
        $rates_item_class = 'rates__item--win';
    } elseif (strtotime($finish_date) <= time()) {
        $rates_item_class = 'rates__item--end';
    } else {
        $rates_item_class = '';
    }
    return $rates_item_class;
}

/**
 * Функция возвращает строку с сообщением или время до окончания размещения лота
 * @param string $finish_date Дата окончания размещения лота
 * @param int $Id Идентификатор пользователя
 * @param ?int $winner_id Идентификатор победителя, при наличии
 * @return string
 */

function timerResult(string $finish_date, int $Id, ?int $winner_id): string
{
    if ($Id === $winner_id) {
        $timer_result = 'Ставка выиграла';
    } elseif (strtotime($finish_date) <= time()) {
        $timer_result = 'Торги окончены';
    } else {
        $timer_result = implode(':', timeLeft($finish_date));
    }
    return $timer_result;
}

/**
 * Функция возвращает id пользователя если авторизован,
 * иначе переадресовывает на 403
 * @return int | null
 */

function getUserIdFromSession(): ?int
{
    $user_id = (int)$_SESSION['user']['id'];
    if (empty($user_id)) {
        header('Location: 403.php');
        exit();
    }
    return $user_id;
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */

function includeTemplate(string $name, array $data = []): string
{
    $name = 'templates/' . $name;
    $result = '';

    if (is_readable($name)) {
        ob_start();
        extract($data);
        require $name;

        $result = ob_get_clean();
    }
    return $result;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 */
function getNounPluralForm(int $number, string $one, string $two, string $many): string
{
    $mod10 = $number % 10;
    $result = $many;

    if ($mod10 === 1) {
        $result = $one;
    }
    if ($mod10 >= 2 && $mod10 <= 4) {
        $result = $two;
    }
    return $result;
}

/**
 * Функция отображения даты создания ставки в удобочитаемом формате
 * @param string $date_create дата создания ставки
 * @return string возвращает отформатированную строку с датой
 */

function pastDate(string $date_create): string
{
    $time = time() - strtotime($date_create);

    $hours = floor($time / 3600);
    $minutes = floor(($time % 3600) / 60);
    $past_date = date_create($date_create);

    $result = date_format($past_date, 'd.m.y в h:i');

    if ($minutes < 1) {
        $result = 'только что';
    }
    if ($hours < 1) {
        $result = $minutes . ' ' . getNounPluralForm($minutes, 'минуту', 'минуты', 'минут') . ' ' . 'назад';
    }
    if (($hours >= 1) && ($hours < 24)) {
        $result = $hours . ' ' . getNounPluralForm($hours, 'час', 'часа', 'часов') . ' ' . 'назад';
    }
    return $result;
}

/**
 * Функция заключает текст в кавычки (текст => <<текст>>)
 * @param string $text исходный текст
 * @return string текст, заключенный в кавычки
 */

function getQuotesForString(string $text): string
{
    return ('«' . $text . '»') ?? '';
}
