<?php
/* @var $this CategoriesController */
/* @var $model FaqCategories */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن FaqCategories', 'url'=>array('create')),
);
?>

<h1>مدیریت Faq Categories</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'faq-categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'sort',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
