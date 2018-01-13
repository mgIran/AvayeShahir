<?php
/* @var $this WritingsCategoryController */
/* @var $model WritingCategories */

$this->breadcrumbs=array(
	'مدیریت دسته بندی رایتینیگ ها'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت دسته بندی رایتینیگ ها', 'url'=>array('admin')),
);
?>

<h1>افزودن دسته بندی رایتینیگ ها</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>