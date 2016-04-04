<?php
/* @var $this CoursesManageController */
/* @var $model Courses */

$this->breadcrumbs=array(
	'مدیریت دوره ها',
);

$this->menu=array(
	array('label'=>'افزودن دوره', 'url'=>array('create')),
);
?>

<h1>مدیریت دوره ها</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'courses-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'summary',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
