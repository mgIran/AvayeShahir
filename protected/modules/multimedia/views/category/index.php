<?php
/* @var $this MultimediaCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Multimedia Categories',
);

$this->menu=array(
	array('label'=>'Create MultimediaCategories', 'url'=>array('create')),
	array('label'=>'Manage MultimediaCategories', 'url'=>array('admin')),
);
?>

<h1>Multimedia Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
