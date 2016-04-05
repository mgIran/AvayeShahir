<?php
/* @var $this ClassesManageController */
/* @var $model Classes */

$this->breadcrumbs=array(
	'مدیریت کلاس ها',
);

$this->menu=array(
	array('label'=>'افزودن کلاس', 'url'=>array('create')),
);
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت کلاس ها</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'classes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'summary',
		'price',
		'startSignupDate',
		'endSingupDate',
		/*
		'startClassDate',
		'endClassDate',
		'category_id',
		'course_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
