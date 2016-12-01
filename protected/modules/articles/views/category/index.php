<?php
/* @var $this ArticlesCategoriesManageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Articles Categories',
);

$this->menu=array(
	array('label'=>'Create ArticlesCategories', 'url'=>array('create')),
	array('label'=>'Manage ArticlesCategories', 'url'=>array('admin')),
);
?>

<h1>Articles Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
