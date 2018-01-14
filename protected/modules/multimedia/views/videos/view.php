<?php
/* @var $this MultimediaVideosController */
/* @var $model Multimedia */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
);

$this->menu=array(
	array('label'=>'افزودن ویدئو', 'url'=>array('create')),
	array('label'=>'ویرایش ویدئو', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف ویدئو', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت ویدئوها', 'url'=>array('admin')),
);
?>

<h1>نمایش ویدئو #<?php echo $model->title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'title',
		'data:raw',
		'seen',
	),
)); ?>
