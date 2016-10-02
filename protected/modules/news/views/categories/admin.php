<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */

$this->breadcrumbs=array(
	'لیست دسته بندی اخبار'
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی', 'url'=>array('create')),
);
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
	<h1>مدیریت دسته بندی اخبار</h1>

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