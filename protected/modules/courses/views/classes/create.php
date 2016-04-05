<?php
/* @var $this ClassesManageController */
/* @var $model Classes */

$this->breadcrumbs=array(
	'لیست کلاس ها'=>array('admin'),
	'افزودن کلاس',
);

$this->menu=array(
	array('label'=>'لیست کلاس ها', 'url'=>array('admin')),
);
?>

<h1>افزودن کلاس</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>