<?php
/* @var $this NewsCategoriesManageController */
/* @var $model NewsCategories */

$this->breadcrumbs=array(
	'News Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NewsCategories', 'url'=>array('index')),
	array('label'=>'Manage NewsCategories', 'url'=>array('admin')),
);
?>

<h1>Create NewsCategories</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>