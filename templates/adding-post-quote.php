<section class="adding-post__quote tabs__content tabs__content--active">
    <h2 class="visually-hidden">Форма добавления цитаты</h2>
    <form class="adding-post__form form" action="add.php?type=quote" method="post">
        <input type="hidden" value="quote" name="type">
        <!-- Крутая фича, запомни. Значения value и name произвольные -->
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <?php $classtitle = isset($displayErrors['quote-heading']) ? "form__input-section--error" : ""; ?>
                <div class="adding-post__input-wrapper form__input-wrapper <?= $classtitle; ?>">
                    <label class="adding-post__label form__label" for="quote-heading">Заголовок
                        <span class="form__input-required">*</span></label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="quote-heading" type="text"
                               name="quote-heading" placeholder="Введите заголовок"
                               value="<?= getPostVal($dataValues, 'title'); ?>">
                        <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $displayErrors['quote-heading'] ?></p>
                        </div>
                    </div>
                </div>
                <?php $classcite = isset($displayErrors['cite-text']) ? "form__input-section--error" : ""; ?>
                <div class="adding-post__input-wrapper form__textarea-wrapper <?= $classcite; ?>">
                    <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span
                            class="form__input-required">*</span></label>
                    <div class="form__input-section">
                                            <textarea
                                                class="adding-post__textarea adding-post__textarea--quote form__textarea form__input"
                                                name="cite-text" id="cite-text"
                                                placeholder="Текст цитаты"><?= getPostVal($dataValues, 'text_content'); ?></textarea>
                        <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $displayErrors['cite-text'] ?></p>
                        </div>
                    </div>
                </div>
                <?php $classauthor = isset($displayErrors['quote-author']) ? "form__input-section--error" : ""; ?>
                <div class="adding-post__textarea-wrapper form__input-wrapper <?= $classauthor; ?>">
                    <label class="adding-post__label form__label" for="quote-author">Автор <span
                            class="form__input-required">*</span></label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="quote-author" type="text"
                               name="quote-author" value="<?= getPostVal($dataValues, 'quote_author'); ?>">
                        <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $displayErrors['quote-author'] ?></p>
                        </div>
                    </div>
                </div>
                <?php $classtags = isset($displayErrors['cite-tags']) ? "form__input-section--error" : ""; ?>
                <div class="adding-post__input-wrapper form__input-wrapper <?= $classtags; ?>">
                    <label class="adding-post__label form__label" for="cite-tags">Теги</label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="cite-tags" type="text"
                               name="cite-tags" placeholder="Введите теги"
                               value="<?= getPostVal($dataValues, 'hashtag'); ?>">
                        <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $displayErrors['cite-tags'] ?></p>
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
