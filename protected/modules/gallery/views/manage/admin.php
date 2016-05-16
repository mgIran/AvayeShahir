<?php
/* @var $this CoursesManageController */
/* @var $model Courses */

$this->breadcrumbs=array(
	'مدیریت گالری',
);

$this->menu=array(
	array('label'=>'افزودن تصویر', 'url'=>array('create')),
);
$fileUrl = Yii::app()->baseUrl.'/uploads/gallery/50x50';
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت گالری</h1>

<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'dataProvider'=>$model->search(),
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
	'id'=>'gallery-grid',
	'filter'=>$model,
	'columns'=>array(
		array(
			'header' => 'تصویر',
			'type' => 'raw',
			'value' => 'CHtml::image("'.$fileUrl.'/$data->file_name",$data->title,array(\'height\' => 50))	'
		),
		'title',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
