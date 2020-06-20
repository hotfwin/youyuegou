<h2><?= $title ?></h2>

<?php if (! empty($news) && is_array($news)) : ?>

        <?php foreach ($news as $news_item): ?>

                <h3><?= $news_item['title'] ?></h3>

                <div class="main">
                        <?= $news_item['body'] ?>
                </div>
                <p><a href="<?= 'newsView/'.$news_item['slug'] ?>">显示详情</a></p>

        <?php endforeach; ?>

<?php else : ?>

        <h3>没有新闻</h3>

        <p>一条新闻也没有.</p>

<?php endif ?>