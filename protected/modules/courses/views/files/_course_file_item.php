<?php
/* @var $this Controller */
/* @var $data ClassCategoryFiles */

$fileUrl = Yii::app()->baseUrl.'/uploads/classCategoryFiles/';
$fileDir = Yii::getPathOfAlias("webroot").'/uploads/classCategoryFiles/';
$imageDir = Yii::getPathOfAlias("webroot").'/uploads/fileImages/';
$imageUrl = Yii::app()->baseUrl.'/uploads/fileImages/';

if($data->path and is_file($fileDir.$data->path)):
	?>
	<li data-toggle="tooltip" data-placement="top" title="<?= CHtml::encode($data->summary) ?>">
		<a href="<?= $fileUrl.$data->path ?>"></a>
		<?php
		if($data->image && is_file($imageDir.$data->image))
			echo CHtml::image($imageUrl.$data->image,$data->title,array('class' => 'file-image'))
		?>
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