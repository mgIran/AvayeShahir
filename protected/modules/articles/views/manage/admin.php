<?php
/* @var $this ArticlesManageController */
/* @var $model Articles */

$this->breadcrumbs=array(
	'لیست مطالب'
);

$this->menu=array(
	array('label'=>'افزودن مطلب', 'url'=>array('create')),
);
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت مطالب</h1>

<?php //$this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
//	'orderField' => 'order',
//	'idField' => 'id',
//	'orderUrl' => 'order',
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
	'id'=>'class-categories-grid',
	'filter'=>$model,
	'columns'=>array(
		'title',
		'title_en',
		array(
			'name' => 'status',
			'value' => '$data->statusLabel',
			'filter' => $model->statusLabels
		),
		array(
			'name' => 'category_id',
			'value' => '$data->category->title',
			'filter' => ArticleCategories::model()->adminSortList(null,false)
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>