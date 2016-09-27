<?php
/* @var $this ManageController */
/* @var $model FAQ */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
);
$this->menu=array(
	array('label'=>'افزودن پرسش و پاسخ', 'url'=>array('create')),
	array('label'=>'ویرایش پرسش و پاسخ', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف پرسش و پاسخ', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت پرسش و پاسخ ها', 'url'=>array('admin')),
);
 ها?>

<h1>نمایش پرسش #<?php echo $model->title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'category.title',
		'title',
		'body',
		'order',
	),
)); ?>
