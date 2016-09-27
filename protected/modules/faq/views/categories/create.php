<?php
/* @var $this CategoriesController */
/* @var $model FaqCategories */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>افزودن FaqCategories</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>