<?php
/* @var $this UsersManageController */
/* @var $model Users */

$this->breadcrumbs=array(
		'مدیریت اساتید'=>array('admin'),
		'افزودن',
);

$this->menu=array(
		array('label'=>'لیست اساتید', 'url'=>array('admin')),
);
?>

<h1>افزودن استاد</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>