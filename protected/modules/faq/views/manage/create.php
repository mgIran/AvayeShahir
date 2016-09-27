<?php
/* @var $this ManageController */
/* @var $model FAQ */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>افزودن پرسش و پاسخ</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>