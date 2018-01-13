<?php
/* @var $this WritingsManageController */
/* @var $model Writings */

$this->breadcrumbs=array(
	'لیست دسته بندی رایتینیگ ها'
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی', 'url'=>array('create')),
	array('label'=>'افزودن رایتینیگ ها', 'url'=>array('manage/create')),
	array('label'=>'مدیریت رایتینیگ ها', 'url'=>array('/writings/manage/admin')),
);
?>
<h1>مدیریت دسته بندی رایتینیگ ها</h1>
<? $this->renderPartial('//layouts/_flashMessage'); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
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