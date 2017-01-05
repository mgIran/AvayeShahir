<?php
/* @var $this ArticlesCategoryController */
/* @var $model ArticleCategories */

$this->breadcrumbs=array(
	'دسته بندی مطالب'=>array('index'),
	$model->title,
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی', 'url'=>array('create')),
	array('label'=>'مدیریت دسته بندی مطالب', 'url'=>array('admin')),
);
?>

<h1>ویرایش دسته بندی مطالب #<?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>