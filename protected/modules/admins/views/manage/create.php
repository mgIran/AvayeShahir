<?php
/* @var $this AdminsManageController */
/* @var $model Admins */

$this->breadcrumbs=array(
    'پیشخوان'=> array('/moderators'),
    'مدیران'=> array('/moderators/manage'),
	'مدیریت'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت مدیران', 'url'=>array('index')),
);
?>

<h1>افزودن مدیر</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>