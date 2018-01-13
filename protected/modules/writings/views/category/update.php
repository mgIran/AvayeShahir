<?php
/* @var $this WritingsCategoryController */
/* @var $model WritingCategories */

$this->breadcrumbs=array(
	'دسته بندی رایتینیگ ها'=>array('index'),
	$model->title,
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی', 'url'=>array('create')),
	array('label'=>'مدیریت دسته بندی رایتینیگ ها', 'url'=>array('admin')),
);
?>

<h1>ویرایش دسته بندی رایتینیگ ها #<?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>