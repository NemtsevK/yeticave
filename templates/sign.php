<?php

require_once __DIR__ . '/../php/main.php';

/**
 * @var $categories
 * @var $form_data
 * @var $errors
 */
?>

    <form class="form container <?= !empty($errors) ? 'form--invalid' : '' ?>" action="sign-up.php" method="post" autocomplete="off">
        <h2>Регистрация нового аккаунта</h2>

        <div class="form__item <?= isset($errors['name']) ? 'form__item--invalid' : '' ?>">
            <label for="name">Имя <sup>*</sup></label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= $form_data['name'] ?? '' ?>"
                <?= (empty($_POST)) ? 'autofocus' : ''?>>
            <span class="form__error"><?= $errors['name'] ?></span>
        </div>

        <div class="form__item <?= isset($errors['email']) ? 'form__item--invalid' : '' ?>">
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $form_data['email'] ?? '' ?>">
            <span class="form__error"><?= $errors['email'] ?? '' ?></span>
        </div>

        <div class="form__item <?= isset($errors['password']) ? 'form__item--invalid' : '' ?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= $form_data['password'] ?? '' ?>">
            <span class="form__error"><?= $errors['password'] ?? ''?></span>
        </div>

        <div class="form__item <?= isset($errors['contact']) ? 'form__item--invalid' : '' ?>">
            <label for="message">Контактные данные <sup>*</sup></label>
            <textarea id="message" name="contact" placeholder="Напишите как с вами связаться"><?= $form_data['contact'] ?? '' ?></textarea>
            <span class="form__error"><?= $errors['contact'] ?? '' ?></span>
        </div>

        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>

        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>

