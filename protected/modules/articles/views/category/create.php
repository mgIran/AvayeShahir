<?php
/* @var $this ArticlesCategoryController */
/* @var $model ArticleCategories */

$this->breadcrumbs=array(
	'مدیریت دسته بندی مطالب'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت دسته بندی مطالب', 'url'=>array('admin')),
);
?>

<h1>افزودن دسته بندی مطالب</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>