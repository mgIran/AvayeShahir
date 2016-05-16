<?php
/* @var $this CoursesManageController */
/* @var $model Courses */
/* @var $image [] */

$this->breadcrumbs=array(
	'مدیریت گالری'=>array('admin'),
	$model->title,
	'ویرایش',
);

$this->menu=array(
	array('label'=>'مدیریت گالری', 'url'=>array('admin')),
	array('label'=>'افزودن تصویر', 'url'=>array('create')),
);
?>

<h1>ویرایش تصویر<?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>