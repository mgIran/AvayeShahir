<?php
/* @var $this ManageController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
);

$this->menu=array(
	array('label'=>'لیست Faq', 'url'=>array('index')),
	array('label'=>'افزودن Faq', 'url'=>array('create')),
	array('label'=>'ویرایش Faq', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف Faq', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت Faq', 'url'=>array('admin')),
);
?>

<h1>نمایش Faq #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'category_id',
		'title',
		'body',
		'sort',
	),
)); ?>
