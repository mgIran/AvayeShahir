<?php
/* @var $this ArticlesManageController */
/* @var $model Articles */

$this->breadcrumbs=array(
	'لیست دسته بندی مطالب'
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی', 'url'=>array('create')),
	array('label'=>'افزودن مطالب', 'url'=>array('manage/create')),
	array('label'=>'مدیریت مطالب', 'url'=>array('/news/manage/admin')),
);
?>
<h1>مدیریت دسته بندی مطالب</h1>
<? $this->renderPartial('//layouts/_flashMessage'); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
	'id'=>'categories-grid',
	'filter'=>$model,
	'columns'=>array(
		'title',
		'title_en',
//		array(
//			'header' => 'والد',
//			'name' => 'parent.fullTitle',
//		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>