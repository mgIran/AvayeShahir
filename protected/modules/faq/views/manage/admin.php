<?php
/* @var $this ManageController */
/* @var $model FAQ */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن FAQ', 'url'=>array('create')),
);
?>

<h1>مدیریت پرسش و پاسخ ها</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'faq-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' =>'category_id',
			'value' => '$data->category->title',
			'filter' => CHtml::listData(FAQCategories::model()->findAll(array('order'=>'t.order DESC')),'id','title')
		),
		'title',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
