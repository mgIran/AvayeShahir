<?php
/* @var $this MultimediaVideosController */
/* @var $model Multimedia */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن ویدئو', 'url'=>array('create')),
);
?>

<h1>مدیریت ویدئو ها</h1>

<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
	'id'=>'multimedia-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'data',
			'type' => 'raw',
			'htmlOptions' => array('style' => 'width:250px;'),
			'filter' => false
		),
		'title',
		'seen',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
