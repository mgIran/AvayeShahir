<?php
/* @var $this CoursesManageController */
/* @var $model Courses */
/* @var $image [] */

$this->breadcrumbs=array(
	'مدیریت گالری'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت گالری', 'url'=>array('admin')),
);
?>

<h1>افزودن تصویر</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'image' => $image)); ?>