<section class="page__main page__main--popular">
    <div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link sorting__link--active" href="#">
                            <span>Популярность</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Лайки</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Дата</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <a class="filters__button filters__button--ellipse filters__button--all <?php if (!$contentIndex) {
                            print('filters__button--active');
                        } ?>"
                           href="../index.php">
                            <span>Все</span>
                        </a>
                    </li>
                    <?php foreach ($contentType as $value): ?>
                        <li class="popular__filters-item filters__item">
                            <a class="filters__button filters__button--<?= $value['icon']; ?> button <?php if ($contentIndex == $value['id']) {
                                print('filters__button--active');
                            } ?>" href="../index.php?tab=<?= $value['id']; ?>">
                                <span class="visually-hidden"><?= $value['type']; ?></span>
                                <svg class="filters__icon" width="22" height="18">
                                    <use xlink:href="#icon-filter-<?= $value['icon']; ?>"></use>
                                </svg>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="popular__posts">


            <!-- Показываем посты -->
            <?php foreach ($contentShow as $value): ?>
                <!-- тип поста -->
                <article class="popular__post post post-<?= $value['icon']; ?>">
                    <header class="post__header">
                        <!--здесь заголовок-->
                        <a href="post.php?id=<?= $value['id']; ?>">
                            <h2><?= $value['title']; ?></h2>
                        </a>
                    </header>
                    <div class="post__main">
                        <!--здесь содержимое карточки-->
                        <?php if ($value['icon'] == 'text'): ?>
                            <!--содержимое для поста-текста-->
                            <p><?= (cut_text($value['text_content'])); ?></p>
                        <?php elseif ($value['icon'] == 'quote'): ?>
                            <!--содержимое для поста-цитаты-->
                            <blockquote>
                                <p>
                                    <?= $value['text_content']; ?>
                                </p>
                                <cite><?= $value['quote_author']; ?></cite>
                            </blockquote>
                        <?php elseif ($value['icon'] == 'photo'): ?>
                            <!--содержимое для поста-фото-->
                            <div class="post-photo__image-wrapper">
                                <img src="<?= $value['image_content']; ?>" alt="Фото от пользователя" width="360"
                                     height="240">
                            </div>
                        <?php elseif ($value['icon'] == 'link'): ?>
                            <!--содержимое для поста-ссылки-->
                            <div class="post-link__wrapper">
                                <a class="post-link__external" href="http://<?= $value['link_content']; ?>" target="_blank" rel="nofollow"
                                   title="Перейти по ссылке">
                                    <div class="post-link__info-wrapper">
                                        <div class="post-link__icon-wrapper">
                                            <img src="https://www.google.com/s2/favicons?domain=<?= $value['link_content']; ?>"
                                                 alt="Иконка">
                                        </div>
                                        <div class="post-link__info">
                                            <h3><?= $value['title']; ?></h3>
                                        </div>
                                    </div>
                                    <span><?= $value['link_content']; ?></span>
                                </a>
                            </div>
                        <?php elseif ($value['icon'] == 'video'): ?>
                            <!--содержимое для поста-видео-->
                            <div class="post-video__block">
                                <div class="post-video__preview">
                                    <?= embed_youtube_cover($value['video_content']); ?>
                                </div>
                                <a href="<?= $value['video_content']; ?>" target="_blank" rel="nofollow" class="post-video__play-big button">
                                    <svg class="post-video__play-big-icon" width="14" height="14">
                                        <use xlink:href="#icon-video-play-big"></use>
                                    </svg>
                                    <span class="visually-hidden">Запустить проигрыватель</span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <footer class="post__footer">
                        <div class="post__author">
                            <a class="post__author-link" href="#" title="Автор">
                                <div class="post__avatar-wrapper">
                                    <!--укажите путь к файлу аватара-->
                                    <img class="post__author-avatar" src="img/<?= $value['avatar_path']; ?>"
                                         alt="Аватар пользователя">
                                </div>
                                <div class="post__info">
                                    <b class="post__author-name">
                                        <!--здесь имя пользователя-->
                                        <?= $value['login']; ?>
                                    </b>
                                    <time class="post__time"
                                          datetime="<?= show_date(($value['timestamp_add']), 'datetime_format'); ?>"
                                          title="<?= show_date(($value['timestamp_add']), 'title_format'); ?>">
                                        <?= show_date(($value['timestamp_add']), 'relative_format'); ?> назад
                                    </time>
                                </div>
                            </a>
                        </div>
                        <div class="post__indicators">
                            <div class="post__buttons">
                                <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                    <svg class="post__indicator-icon" width="20" height="17">
                                        <use xlink:href="#icon-heart"></use>
                                    </svg>
                                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20"
                                         height="17">
                                        <use xlink:href="#icon-heart-active"></use>
                                    </svg>
                                    <span>0</span>
                                    <span class="visually-hidden">количество лайков</span>
                                </a>
                                <a class="post__indicator post__indicator--comments button" href="#"
                                   title="Комментарии">
                                    <svg class="post__indicator-icon" width="19" height="17">
                                        <use xlink:href="#icon-comment"></use>
                                    </svg>
                                    <span>0</span>
                                    <span class="visually-hidden">количество комментариев</span>
                                </a>
                            </div>
                        </div>
                    </footer>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
