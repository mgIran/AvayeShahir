<?php
/* @var $this CoursesManageController */
/* @var $model Courses */

$this->breadcrumbs=array(
	'مدیریت دوره ها و منابع'=>array('admin'),
	'زباله دان',
);

$this->menu=array(
	array('label'=>'مدیریت دوره ها و منابع', 'url'=>array('admin')),
	array('label'=>'افزودن دوره', 'url'=>array('create')),
);
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>زباله دان دوره ها و منابع</h1>

<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'dataProvider'=>$model->search(),
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
	'id'=>'courses-grid',
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'header' => 'توضیحات',
			'value' => 'substr($data->summary,0,500)'
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{restore} {delete}',
			'buttons' => array(
				'delete' => array(
					'label' => 'پاک کردن برای همیشه',
					'options' => array('class' => 'btn btn-danger btn-sm','style' => 'margin:10px 0 5px'),
					'imageUrl' => false
				),
				'restore' => array(
					'label' => 'بازیابی',
					'options' => array('class' => 'btn btn-success btn-sm','style' => 'margin-top:5px'),
					'url' => 'Yii::app()->createUrl("/courses/manage/restore",array("id" => $data->id))'
				)
			)
		),
	),
)); ?>
