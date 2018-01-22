<?php
/* @var $this WritingsManageController */
/* @var $model Writings */

$this->breadcrumbs=array(
	'لیست رایتینیگ ها'
);

$this->menu=array(
	array('label'=>'افزودن رایتینیگ', 'url'=>array('create')),
	array('label'=>'مدیریت دسته بندی های رایتینیگ', 'url'=>array('/writings/category/admin')),
	array('label'=>'افزودن دسته بندی رایتینیگ', 'url'=>array('/writings/category/create')),
);
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت رایتینیگ ها</h1>

<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
//$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
	'id'=>'class-categories-grid',
	'filter'=>$model,
	'columns'=>array(
		'title',
		'title_en',
		array(
			'name' => 'status',
			'value' => '$data->statusLabel',
			'filter' => $model->statusLabels
		),
		array(
			'name' => 'category_id',
			'value' => '$data->category->title',
			'filter' => WritingCategories::model()->adminSortList(null,false)
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{view}{update}{delete}'
		),
	),
)); ?>