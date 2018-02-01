<?php
/* @var $this MultimediaCategoryController */
/* @var $model MultimediaCategories */

$this->breadcrumbs=array(
	'مدیریت دسته بندی چندرسانه ای'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت دسته بندی چندرسانه ای', 'url'=>array('admin')),
);
?>

<h1>افزودن دسته بندی چندرسانه ای</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>