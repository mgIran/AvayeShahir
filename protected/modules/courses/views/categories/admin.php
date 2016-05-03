<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */

$this->breadcrumbs=array(
	'لیست گروه بندی کلاس ها'
);

$this->menu=array(
	array('label'=>'افزودن گروه', 'url'=>array('create')),
);
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت گروه بندی کلاس ها</h1>

<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'dataProvider'=>$model->search(),
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
	'id'=>'class-categories-grid',
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'header' => 'دوره',
			'name' => 'course.title',
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>

<?php /*$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'class-categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'header' => 'دوره',
			'name' => 'course.title',
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); */?>
