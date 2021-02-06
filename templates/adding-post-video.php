<section class="adding-post__video tabs__content tabs__content--active">
    <h2 class="visually-hidden">Форма добавления видео</h2>
    <form class="adding-post__form form" action="add.php?type=video" method="post" enctype="multipart/form-data">
        <input type="hidden" value="video" name="type">
        <!-- Крутая фича, запомни. Значения value и name произвольные -->
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <?php $classtitle = isset($displayErrors['video-heading']) ? "form__input-section--error" : ""; ?>
                <div class="adding-post__input-wrapper form__input-wrapper <?= $classtitle; ?>">
                    <label class="adding-post__label form__label" for="video-heading">Заголовок
                        <span class="form__input-required">*</span></label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="video-heading" type="text"
                               name="video-heading" placeholder="Введите заголовок"
                               value="<?= getPostVal($dataValues, 'title'); ?>">
                        <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $displayErrors['video-heading'] ?></p>
                        </div>
                    </div>
                </div>
                <?php $classvideo = isset($displayErrors['video-url']) ? "form__input-section--error" : ""; ?>
                <div class="adding-post__input-wrapper form__input-wrapper <?= $classvideo; ?>">
                    <label class="adding-post__label form__label" for="video-url">Ссылка youtube
                        <span class="form__input-required">*</span></label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="video-url" type="text"
                               name="video-url" placeholder="Введите ссылку"
                               value="<?= getPostVal($dataValues, 'video_content'); ?>">
                        <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $displayErrors['video-url'] ?></p>
                        </div>
                    </div>
                </div>
                <?php $classtags = isset($displayErrors['video-tags']) ? "form__input-section--error" : ""; ?>
                <div class="adding-post__input-wrapper form__input-wrapper <?= $classtags; ?>">
                    <label class="adding-post__label form__label" for="video-tags">Теги</label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="video-tags" type="text"
                               name="video-tags" placeholder="Введите теги"
                               value="<?= getPostVal($dataValues, 'hashtag'); ?>">
                        <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $displayErrors['video-tags'] ?></p>
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
