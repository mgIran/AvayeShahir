<?php
/* @var $this PersonnelManageController */
/* @var $model Personnel */

$this->breadcrumbs=array(
	'کارمندان'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'لیست کارمندان', 'url'=>array('admin')),
);
?>

<h1>افزودن کارمند</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'avatar' => $avatar)); ?>