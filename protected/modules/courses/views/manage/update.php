<?php
/* @var $this CoursesManageController */
/* @var $model Courses */
/* @var $pic [] */

$this->breadcrumbs=array(
	'مدیریت دوره ها'=>array('admin'),
	$model->title,
	'ویرایش',
);

$this->menu=array(
	array('label'=>'مدیریت دوره ها', 'url'=>array('admin')),
	array('label'=>'افزودن دوره', 'url'=>array('create')),
);
?>

<h1>ویرایش دوره <?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'pic' => $pic)); ?>