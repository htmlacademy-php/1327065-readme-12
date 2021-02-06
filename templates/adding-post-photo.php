<section class="adding-post__photo tabs__content tabs__content--active">
    <h2 class="visually-hidden"> Форма добавления фото </h2>
    <form class="adding-post__form form" action="add.php?type=photo" method="post" enctype="multipart/form-data">
        <!--        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />-->
        <input type="hidden" value="photo" name="type">
        <!-- Крутая фича, запомни. Значения value и name произвольные -->
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <?php $classtitle = isset($displayErrors['photo-heading']) ? "form__input-section--error" : ""; ?>
                <div class="adding-post__input-wrapper form__input-wrapper <?= $classtitle; ?>">
                    <label class="adding-post__label form__label" for="photo-heading"> Заголовок
                        <span class="form__input-required">*</span></label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="photo-heading" type="text"
                               name="photo-heading" placeholder="Введите заголовок"
                               value="<?= getPostVal($dataValues, 'title'); ?>">
                        <button class="form__error-button button" type="button"> !<span
                                class="visually-hidden"> Информация об ошибке </span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title"> Заголовок сообщения </h3>
                            <p class="form__error-desc"><?= $displayErrors['photo-heading'] ?></p>
                        </div>
                    </div>
                </div>
                <?php $classphotourl = isset($displayErrors['photo-url']) ? "form__input-section--error" : ""; ?>
                <div class="adding-post__input-wrapper form__input-wrapper <?= $classphotourl; ?>">
                    <label class="adding-post__label form__label" for="photo-url"> Ссылка из
                        интернета </label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="photo-url" type="text"
                               name="photo-url" placeholder="Введите ссылку"
                               value="<?= getPostVal($dataValues, 'photo-url'); ?>">
                        <button class="form__error-button button" type="button"> !<span
                                class="visually-hidden"> Информация об ошибке </span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title"> Заголовок сообщения </h3>
                            <p class="form__error-desc"><?= $displayErrors['photo-url'] ?></p>
                        </div>
                    </div>
                </div>
                <?php $classtags = isset($displayErrors['photo-tags']) ? "form__input-section--error" : ""; ?>
                <div class="adding-post__input-wrapper form__input-wrapper <?= $classtags; ?>">
                    <label class="adding-post__label form__label" for="photo-tags"> Теги</label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="photo-tags" type="text"
                               name="photo-tags" placeholder="Введите теги"
                               value="<?= getPostVal($dataValues, 'hashtag'); ?>">
                        <button class="form__error-button button" type="button"> !<span
                                class="visually-hidden"> Информация об ошибке </span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title"> Заголовок сообщения </h3>
                            <p class="form__error-desc"><?= $displayErrors['photo-tags'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form__invalid-block
            <?php if (!$displayErrors) {
                echo "visually-hidden";
            } ?>">
                <b class="form__invalid-slogan"> Пожалуйста, исправьте следующие ошибки:</b>
                <ul class="form__invalid-list">
                    <?php if (is_array($displayErrors)) : ?>
                        <?php foreach ($displayErrors as $field => $error): ?>
                            <li class="form__invalid-item"><?= $error; ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="adding-post__input-file-container form__input-container form__input-container--file">
            <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                <?php $classuserpicfile = isset($displayErrors['userpic-file-photo']) ? "form__input-section--error" : ""; ?>
                <div
                    class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone <?= $classuserpicfile; ?>">
                    <input class="adding-post__input-file form__input-file" id="userpic-file-photo"
                           type="file" name="userpic-file-photo" title=" ">
                    <!-- Здесь. Подсветку докрути после того как разберешься с JS-файлами, которые блокируют нормальную работу файла-->
                    <div class="form__file-zone-text">
                        <span> Перетащите фото сюда </span>
                    </div>
                </div>
                <button
                    class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button"
                    type="button">
                    <span> Выбрать фото </span>
                    <svg class="adding-post__attach-icon form__attach-icon" width="10" height="20">
                        <use xlink:href="#icon-attach"></use>
                    </svg>
                </button>
            </div>
            <div class="adding-post__file adding-post__file--photo form__file dropzone-previews">

            </div>
        </div>
        <div class="adding-post__buttons">
            <button class="adding-post__submit button button--main" type="submit"> Опубликовать
            </button>
            <a class="adding-post__close" href="#"> Закрыть</a>
        </div>
    </form>
</section>
