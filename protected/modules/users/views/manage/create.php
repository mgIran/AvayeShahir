<?php
/* @var $this UsersManageController */
/* @var $model Users */

$this->breadcrumbs=array(
	'مدیریت کاربران'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'لیست کاربران', 'url'=>array('admin')),
);
?>

<h1>افزودن کاربر</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>