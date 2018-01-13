<?php
/* @var $this WritingsCategoriesManageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Writings Categories',
);

$this->menu=array(
	array('label'=>'Create WritingsCategories', 'url'=>array('create')),
	array('label'=>'Manage WritingsCategories', 'url'=>array('admin')),
);
?>

<h1>Writings Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
