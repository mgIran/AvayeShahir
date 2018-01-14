<?php
/* @var $this MultimediaVideosController */
/* @var $model Multimedia */
/* @var $thumbnail array */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>افزودن ویدئو</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'thumbnail'=>$thumbnail)); ?>