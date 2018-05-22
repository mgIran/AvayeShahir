<?php
/** @var $this Controller */
/** @var $file ClassCategoryFiles|ArticleFiles */
/** @var $fileDir string */
/** @var $fileUrl string */

$fileUrl = Yii::app()->baseUrl.'/uploads/classCategoryFiles/';
$fileDir = Yii::getPathOfAlias("webroot").'/uploads/classCategoryFiles/';
$imageDir = Yii::getPathOfAlias("webroot").'/uploads/fileImages/';
$imageUrl = Yii::app()->baseUrl.'/uploads/fileImages/';

if(isset($file) && $file):
    if($file->path && is_file($fileDir.$file->path)):?>
        <li data-toggle="tooltip" data-placement="top" title="<?= CHtml::encode($file->summary) ?>">
            <a href="<?= $fileUrl.$file->path ?>"></a>
            <?php if($file->image && is_file($imageDir.$file->image)): ?>
                <a href="<?= $imageUrl.$file->image ?>" class="file-image magnifier-trigger" data-toggle="modal" data-target="#magnifier-modal">
                    <?php echo CHtml::image($imageUrl.$file->image,$file->title) ?>
                </a>
            <?php endif; ?>
            <div><?= $file->title ?></div>
            <span class="extension"><?= strtoupper($file->file_type) ?></span>
            <span class="download">
                <i></i>
                <span><?= Yii::t('app','Download'); ?></span>
                <span class="size"><?= Controller::fileSize($fileDir.$file->path) ?></span>
            </span>
        </li>
    <? endif;
endif;