<?php
/* @var $this MultimediaVideosController */
/* @var $model Multimedia */
/* @var $thumbnail array */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن', 'url'=>array('create')),
    array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>ویرایش ویدئو <?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'thumbnail'=>$thumbnail)); ?>