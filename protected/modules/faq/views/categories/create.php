<?php
/* @var $this CategoriesController */
/* @var $model FAQCategories */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>افزودن دسته بندی FAQ</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>