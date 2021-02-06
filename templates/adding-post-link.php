<section class="adding-post__link tabs__content tabs__content--active">
    <h2 class="visually-hidden">Форма добавления ссылки</h2>
    <form class="adding-post__form form" action="add.php?type=link" method="post">
        <input type="hidden" value="link" name="type"> <!-- Крутая фича, запомни. Значения value и name произвольные -->
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <?php $classtitle = isset($displayErrors['link-heading']) ? "form__input-section--error" : ""; ?>
                <div class="adding-post__input-wrapper form__input-wrapper <?= $classtitle; ?>">
                    <label class="adding-post__label form__label" for="link-heading">Заголовок <span
                            class="form__input-required">*</span></label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="link-heading" type="text"
                               name="link-heading" placeholder="Введите заголовок"
                               value="<?= getPostVal($dataValues, 'title'); ?>">
                        <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $displayErrors['link-heading'] ?></p>
                        </div>
                    </div>
                </div>
                <?php $classlink = isset($displayErrors['post-link']) ? "form__input-section--error" : ""; ?>
                <div class="adding-post__textarea-wrapper form__input-wrapper <?= $classlink; ?>">
                    <label class="adding-post__label form__label" for="post-link">Ссылка <span
                            class="form__input-required">*</span></label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="post-link" type="text"
                               name="post-link" value="<?= getPostVal($dataValues, 'link_content'); ?>">
                        <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $displayErrors['post-link'] ?></p>
                        </div>
                    </div>
                </div>
                <?php $classtags = isset($displayErrors['link-tags']) ? "form__input-section--error" : ""; ?>
                <div class="adding-post__input-wrapper form__input-wrapper <?= $classtags; ?>">
                    <label class="adding-post__label form__label" for="link-tags">Теги</label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="link-tags" type="text"
                               name="link-tags" placeholder="Введите теги"
                               value="<?= getPostVal($dataValues, 'hashtag'); ?>">
                        <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $displayErrors['link-tags'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form__invalid-block
            <?php if (!$displayErrors) {
                echo "visually-hidden";
            } ?>">
                <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                <ul class="form__invalid-list">
                    <?php if (is_array($displayErrors)) : ?>
                        <?php foreach ($displayErrors as $field => $error): ?>
                            <li class="form__invalid-item"><?= $error; ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="adding-post__buttons">
            <button class="adding-post__submit button button--main" type="submit">Опубликовать
            </button>
            <a class="adding-post__close" href="#">Закрыть</a>
        </div>
    </form>
</section>
