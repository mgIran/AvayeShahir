<?php
/* @var $this ArticlesManageController */
/* @var $data ArticleLinks */
/* @var $form CActiveForm */
?>
<li class="ext-link-item-container" data-toggle="tooltip" data-placement="top" title="<?= CHtml::encode($data->summary) ?>">
	<a href="<?= $data->link ?>" target="_blank" rel="nofollow"></a>
	<div><?= $data->title ?></div>
</li>
