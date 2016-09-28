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
<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'dataProvider'=>$model->search(),
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
	'id'=>'faq-categories-grid',
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
