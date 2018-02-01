<?php
/* @var $this MultimediaCategoryController */
/* @var $model MultimediaCategories */

$this->breadcrumbs=array(
	'دسته بندی چندرسانه ای'=>array('index'),
	$model->title,
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی', 'url'=>array('create')),
	array('label'=>'مدیریت دسته بندی چندرسانه ای', 'url'=>array('admin')),
);
?>

<h1>ویرایش دسته بندی چندرسانه ای #<?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>