<?php
/* @var $this CategoriesController */
/* @var $model FaqCategories */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
);

$this->menu=array(
	array('label'=>'لیست FaqCategories', 'url'=>array('index')),
	array('label'=>'افزودن FaqCategories', 'url'=>array('create')),
	array('label'=>'ویرایش FaqCategories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف FaqCategories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت FaqCategories', 'url'=>array('admin')),
);
?>

<h1>نمایش FaqCategories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'sort',
	),
)); ?>
