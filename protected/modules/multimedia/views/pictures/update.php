<?php
/* @var $this MultimediaPicturesController */
/* @var $model Multimedia */

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

<h1>ویرایش Multimedia <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'data' => $data)); ?>