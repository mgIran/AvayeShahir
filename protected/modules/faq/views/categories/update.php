<?php
/* @var $this CategoriesController */
/* @var $model FAQCategories */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن', 'url'=>array('create')),
    array('label'=>'مدیریت', 'url'=>array('admin')),
);
?>

<h1>ویرایش دسته بندی FAQ - <?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>