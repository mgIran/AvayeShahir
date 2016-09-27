<?php
/* @var $this ManageController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>افزودن Faq</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>