<?php
/* @var $this ClassTagsManageController */
/* @var $model ClassTags */

$this->breadcrumbs=array(
	'مدیریت برچسب ها',
);

$this->menu=array(
	array('label'=>'افزودن برچسب', 'url'=>array('create')),
);
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت برچسب ها</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'class-tags-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
