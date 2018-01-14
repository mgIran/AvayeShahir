<?php
/* @var $this MultimediaPicturesController */
/* @var $model Multimedia */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>افزودن تصویر</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'data' => $data)); ?>