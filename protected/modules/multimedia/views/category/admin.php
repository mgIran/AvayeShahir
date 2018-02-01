<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */

$this->breadcrumbs=array(
	'لیست دسته بندی چندرسانه ای'
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی', 'url'=>array('create')),
	array('label'=>'افزودن ویدئو', 'url'=>array('/multimedia/videos/create')),
	array('label'=>'مدیریت ویدئوها', 'url'=>array('/multimedia/videos/admin')),
	array('label'=>'افزودن تصویر', 'url'=>array('/multimedia/pictures/create')),
	array('label'=>'مدیریت تصاویر', 'url'=>array('/multimedia/pictures/admin')),
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