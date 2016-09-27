<?php
/* @var $this ManageController */
/* @var $model FAQ */

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

<h1>ویرایش پرسش و پاسخ <?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>