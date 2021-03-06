<?php
/* @var $this ArticlesManageController */
/* @var $data ArticleFileLinks */
/* @var $form CActiveForm */
$imageDir = Yii::getPathOfAlias("webroot").'/uploads/articles/fileimages/';
$imageUrl = Yii::app()->baseUrl.'/uploads/articles/fileimages/';
?>
<?php
if($data->link):
	?>
	<li class="link-item-container" data-toggle="tooltip" data-placement="top" title="<?= CHtml::encode($data->summary) ?>">
        <a target="_blank" rel="nofollow" href="<?= $data->link ?>"></a>
        <?php if($data->image && is_file($imageDir.$data->image)): ?>
            <a data-href="<?= $imageUrl.$data->image ?>" class="file-image magnifier-trigger" data-toggle="modal" data-target="#magnifier-modal">
                <?php echo CHtml::image($imageUrl.$data->image,$data->title); ?>
            </a>
        <?php endif; ?>
		<div><?= $data->title ?></div>
		<span class="extension"><?= strtoupper($data->file_type) ?></span>
		<span class="download">
			<i></i>
			<span><?= Yii::t('app','Download'); ?></span>
			<?= $data->link_size?'<span class="size">'.$data->link_size.'</span>':'' ?>
		</span>
	</li>
	<?
endif;