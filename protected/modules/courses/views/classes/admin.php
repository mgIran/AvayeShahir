<?php
/* @var $this ClassesManageController */
/* @var $model Classes */

$this->breadcrumbs=array(
	'مدیریت کلاس ها',
);

$this->menu=array(
	array('label'=>'افزودن کلاس', 'url'=>array('create')),
);
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت کلاس ها</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'classes-grid',
	'dataProvider'=>$model->search(),
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
		),
	),
)); ?>
