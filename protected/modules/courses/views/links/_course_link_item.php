<?php
/* @var $this Controller */
/* @var $data ClassCategoryFileLinks */

$imageDir = Yii::getPathOfAlias("webroot").'/uploads/fileImages/';
$imageUrl = Yii::app()->baseUrl.'/uploads/fileImages/';

if($data->link):
	?>
	<li data-toggle="tooltip" data-placement="top" title="<?= CHtml::encode($data->summary) ?>">
		<a target="_blank" rel="nofollow" href="<?= $data->link ?>"></a>
		<?php
		if($data->image && is_file($imageDir.$data->image))
			echo CHtml::image($imageUrl.$data->image,$data->title,array('class' => 'file-image'))
		?>
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