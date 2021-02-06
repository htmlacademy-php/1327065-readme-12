<main class="page__main page__main--adding-post">
    <div class="page__main-section">
        <div class="container">
            <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
            <div class="adding-post__tabs-wrapper tabs">
                <div class="adding-post__tabs filters">
                    <ul class="adding-post__tabs-list filters__list tabs__list">
                        <?php foreach ($tabType as $value): ?>
                            <li class="adding-post__tabs-item filters__item">
                                <a
                                    class="adding-post__tabs-link filters__button filters__button--<?= $value['icon']; ?> tabs__item button
                                    <?php if ($contentIndex == $value['icon']) {
                                        print('filters__button--active tabs__item--active');
                                    } ?>
                                    "
                                    href="../add.php?type=<?= $value['icon']; ?>"
                                >
                                    <svg class="filters__icon" width="22" height="18">
                                        <use xlink:href="#icon-filter-<?= $value['icon']; ?>"></use>
                                    </svg>
                                    <span><?= $value['type']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="adding-post__tab-content">

                    <?= $addPost; ?>

                </div>
            </div>
        </div>
    </div>
</main>
