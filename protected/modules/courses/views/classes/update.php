<?php
/* @var $this ClassesManageController */
/* @var $model Classes */

$this->breadcrumbs=array(
	'لیست کلاس ها'=>array('admin'),
	$model->title,
	'ویرایش',
);

$this->menu=array(
	array('label'=>'لیست کلاس ها', 'url'=>array('admin')),
	array('label'=>'افزودن کلاس', 'url'=>array('create')),
);
?>

<h1>ویرایش کلاس <?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>