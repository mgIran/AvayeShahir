<?php
/* @var $this CoursesManageController */
/* @var $model Courses */

$this->breadcrumbs=array(
	'مدیریت دوره ها',
);

$this->menu=array(
	array('label'=>'افزودن دوره', 'url'=>array('create')),
	array('label'=>'زباله دان', 'url'=>array('recycleBin')),
);
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت دوره ها</h1>

<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'dataProvider'=>$model->search(),
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
	'id'=>'courses-grid',
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'header' => 'توضیحات',
			'value' => 'substr($data->summary,0,500)'
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
