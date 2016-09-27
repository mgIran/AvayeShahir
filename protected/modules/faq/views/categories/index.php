<?php
/* @var $this CategoriesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'FAQ Categories',
);

$this->menu=array(
	array('label'=>'افزودن ', 'url'=>array('create')),
	array('label'=>'مدیریت ', 'url'=>array('admin')),
);
?>

<h1>FAQ Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
