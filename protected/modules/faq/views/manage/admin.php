<?php
/* @var $this ManageController */
/* @var $model FAQ */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن پرسش و پاسخ', 'url'=>array('create')),
	array('label'=>'افزودن دسته بندی پرسش و پاسخ', 'url'=>array('/faq/categories/create')),
);
?>

<h1>مدیریت پرسش و پاسخ ها</h1>
<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'dataProvider'=>$model->search(),
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
	'id'=>'faq-grid',
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' =>'category_id',
			'value' => '$data->category->title',
			'filter' => CHtml::listData(FaqCategories::model()->findAll(array('order'=>'t.order DESC')),'id','title')
		),
		'title',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
		),
	),
)); ?>
