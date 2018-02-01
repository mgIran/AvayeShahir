<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */

$this->breadcrumbs=array(
	'لیست دسته بندی چندرسانه ای'
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی', 'url'=>array('create')),
	array('label'=>'افزودن چندرسانه ای', 'url'=>array('manage/create')),
	array('label'=>'مدیریت چندرسانه ای', 'url'=>array('/multimedia/manage/admin')),
);
?>
<h1>مدیریت دسته بندی چندرسانه ای</h1>
<? $this->renderPartial('//layouts/_flashMessage'); ?>

<?php
$this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
	'dataProvider'=>$model->search(),
	'id'=>'categories-grid',
	'filter'=>$model,
	'columns'=>array(
		'title',
		'title_en',
		array(
			'header' => 'والد',
			'name' => 'parent.fullTitle',
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>