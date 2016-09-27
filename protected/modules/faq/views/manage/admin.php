<?php
/* @var $this ManageController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن Faq', 'url'=>array('create')),
);
?>

<h1>مدیریت Faqs</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'faq-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' =>'category_id',
			'value' => 'category.title',
			'filter' => CHtml::listData(FaqCategories::model()->findAll(array('order'=>'sort DESC')),'id','title')
		),
		'title',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
