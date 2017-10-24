<?php
/* @var $this OrdersCategoriesController */
/* @var $model OrderCategories */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
);

$this->menu=array(
	array('label'=>'لیست OrderCategories', 'url'=>array('index')),
	array('label'=>'افزودن OrderCategories', 'url'=>array('create')),
	array('label'=>'ویرایش OrderCategories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف OrderCategories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت OrderCategories', 'url'=>array('admin')),
);
?>

<h1>نمایش OrderCategories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
	),
)); ?>
