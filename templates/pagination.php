<?php
/**
 * @var $total_pages_count
 * @var $current_page_number
 * @var $get_param
 * @var $search
 */
?>

<?php if ($total_pages_count > 1): ?>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev">
            <a class="<?= ($current_page_number === 1) ? 'page__item--hidden' : '' ?>"
               href="?page=<?= $current_page_number - 1 ?><?= $get_param ?? '' ?>">Назад
            </a>
        </li>
        <?php for ($i = 1; $i <= $total_pages_count; $i++): ?>
            <li class="pagination-item <?= ($current_page_number === $i) ? 'pagination-item-active' : '' ?>">
                <a href="?page=<?= $i ?><?= $get_param ?? '' ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        <li class="pagination-item pagination-item-next">
            <a class="<?= ($current_page_number === $total_pages_count) ? 'page__item--hidden' : '' ?>"
               href="?page=<?= ($current_page_number + 1) ?><?= $get_param ?? '' ?>">Вперед
            </a>
        </li>
    </ul>
<?php endif; ?>
