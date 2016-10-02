<?php
/* @var $this NewsCategoriesManageController */
/* @var $model NewsCategories */

$this->breadcrumbs=array(
	'News Categories'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List NewsCategories', 'url'=>array('index')),
	array('label'=>'Create NewsCategories', 'url'=>array('create')),
	array('label'=>'Update NewsCategories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NewsCategories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NewsCategories', 'url'=>array('admin')),
);
?>

<h1>View NewsCategories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'parent_id',
		'path',
	),
)); ?>
