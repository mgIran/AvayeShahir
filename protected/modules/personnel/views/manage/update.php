<?php
/* @var $this PersonnelManageController */
/* @var $model Personnel */
/* @var $avatar [] */

$this->breadcrumbs=array(
	'کارمندان'=>array('admin'),
	$model->name.' '.$model->family,
	'ویرایش',
);

$this->menu=array(
	array('label'=>'لیست کارمندان', 'url'=>array('admin')),
	array('label'=>'افزودن', 'url'=>array('create')),
);
?>

<h1>ویرایش کارمند <?php echo $model->name.' '.$model->family; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'avatar' => $avatar)); ?>