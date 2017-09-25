<?php
/* @var $this ManageController */
/* @var $model Slideshow */

$this->breadcrumbs=array(
	'لیست تصاویر'=>array('admin'),
	'افزودن تصاویر',
);

$this->menu=array(
	array('label'=>'لیست تصاویر', 'url'=>array('admin')),
);
?>

<h1>افزودن تصاویر</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>