<?php
/* @var $this CategoriesController */
/* @var $model FAQCategories */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی FAQ', 'url'=>array('create')),
);
?>

<h1>مدیریت دسته بندی های FAQ</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'faq-categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
