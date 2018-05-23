<?php
/* @var $this ArticlesManageController */
/* @var $data ArticleFiles */
/* @var $form CActiveForm */
$fileUrl = Yii::app()->baseUrl.'/uploads/articles/files/';
$fileDir = Yii::getPathOfAlias("webroot").'/uploads/articles/files/';
$imageDir = Yii::getPathOfAlias("webroot").'/uploads/articles/fileimages/';
$imageUrl = Yii::app()->baseUrl.'/uploads/articles/fileimages/';
?>
<?php
if($data->path and is_file($fileDir.$data->path)):
	?>
	<li class="file-item-container" data-toggle="tooltip" data-placement="top" title="<?= CHtml::encode($data->summary) ?>">
		<a href="<?= $fileUrl.$data->path ?>"></a>
        <?php if($data->image && is_file($imageDir.$data->image)): ?>
            <a data-href="<?= $imageUrl.$data->image ?>" class="file-image magnifier-trigger" data-toggle="modal" data-target="#magnifier-modal">
                <?php echo CHtml::image($imageUrl.$data->image,$data->title) ?>
            </a>
        <?php endif; ?>
		<div><?= $data->title ?></div>
		<span class="extension"><?= strtoupper($data->file_type) ?></span>
		<span class="download">
			<i></i>
			<span><?= Yii::t('app','Download'); ?></span>
			<span class="size"><?= Controller::fileSize($fileDir.$data->path) ?></span>
		</span>
	</li>
	<?
endif;
