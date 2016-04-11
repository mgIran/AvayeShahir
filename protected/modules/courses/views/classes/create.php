<?php
/* @var $this ClassesManageController */
/* @var $model Classes */

$this->breadcrumbs=array(
	'لیست کلاس ها'=>array('admin'),
	'افزودن کلاس',
);

$this->menu=array(
	array('label'=>'لیست کلاس ها', 'url'=>array('admin')),
	array('label'=>'افزودن دوره', 'url'=>array('/courses/manage/create?return=true')),
	array('label'=>'افزودن استاد', 'url'=>array('/users/teachers/create?return=true')),
	array('label'=>'افزودن گروه', 'url'=>array('/courses/categories/create?return=true')),
);
?>

<h1>افزودن کلاس</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>