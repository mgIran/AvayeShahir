<?php
/* @var $this PersonnelManageController */
/* @var $model Personnel */

$this->breadcrumbs=array(
		'کارمندان'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'افزودن', 'url'=>array('create')),
);
?>

<h1>View Personnel #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'family',
		'post',
		'avatar',
		'resume',
		'email',
		'social_links',
		'grade',
	),
)); ?>
