<?php
/* @var $this ClassesManageController */
/* @var $model Classes */

$this->breadcrumbs=array(
	'مدیریت کلاس ها',
);

$this->menu=array(
	array('label'=>'لیست کلاس ها', 'url'=>array('admin')),
);
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>زباله دان کلاس ها</h1>

<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'dataProvider'=>$model->search(),
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
	'id'=>'classes-grid',
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'header' => 'دوره',
			'value' => '$data->course->title',
			'filter' => CHtml::activeDropDownList($model,'course_id',
				CHtml::listData(Courses::model()->findAll(),'id' ,'title'),
				array(
					'prompt' => 'همه'
				)
			)
		),
		array(
			'header' => 'گروه',
			'value' => '$data->category->title',
			'filter' => CHtml::activeDropDownList($model,'category_id',
				CHtml::listData(ClassCategories::model()->findAll(),'id' ,'title'),
				array(
					'prompt' => 'همه'
				)
			)
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
					'url' => 'Yii::app()->createUrl("/courses/classes/restore",array("id" => $data->id))'
				)
			)
		),
	),
)); ?>
