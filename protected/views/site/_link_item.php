<?php
/** @var $this Controller */
/** @var $file ClassCategoryFiles|ArticleFiles */
/** @var $fileDir string */
/** @var $fileUrl string */

$imageDir = Yii::getPathOfAlias("webroot").'/uploads/fileImages/';
$imageUrl = Yii::app()->baseUrl.'/uploads/fileImages/';

if(isset($fileLink) && $fileLink):
    if($fileLink->link):
        ?>
        <li data-toggle="tooltip" data-placement="top" title="<?= CHtml::encode($fileLink->summary) ?>">
            <a target="_blank" rel="nofollow" href="<?= $fileLink->link ?>"></a>
            <?php if($fileLink->image && is_file($imageDir.$fileLink->image)): ?>
                <a data-href="<?= $imageUrl.$fileLink->image ?>" class="file-image magnifier-trigger" data-toggle="modal" data-target="#magnifier-modal">
                    <?php echo CHtml::image($imageUrl.$fileLink->image,$fileLink->title); ?>
                </a>
            <?php endif; ?>
            <div><?= $fileLink->title ?></div>
            <span class="extension"><?= strtoupper($fileLink->file_type) ?></span>
            <span class="download">
                <i></i>
                <span><?= Yii::t('app','Download'); ?></span>
                <?= $fileLink->link_size?'<span class="size">'.$fileLink->link_size.'</span>':'' ?>
            </span>
        </li>
    <?
    endif;
endif;