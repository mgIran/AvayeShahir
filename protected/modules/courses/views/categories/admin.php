<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */

$this->breadcrumbs=array(
	'لیست گروه بندی کلاس ها'
);

$this->menu=array(
	array('label'=>'افزودن گروه', 'url'=>array('create')),
);
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت گروه بندی کلاس ها</h1>

<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'dataProvider'=>$model->search(),
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
	'id'=>'class-categories-grid',
	'filter'=>$model,
	'columns'=>array(
		'title',
		'title_en',
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
			'name' => 'status',
			'value' => '$data->getStatusLabel()',
			'filter' => $model->statusLabels
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{active}{deactive}',
			'buttons' => array(
				'active' => array
				(
					'label'=>'فعال',
					'imageUrl'=>Yii::app()->baseUrl."/images/valid.png",
					'visible' => '$data->status == ClassCategories::STATUS_DEACTIVE',
					'click'=>"function(){
						$.fn.yiiGridView.update('class-categories-grid', {
							type:'POST',
							url:$(this).attr('href'),
							success:function(data) {
								$.fn.yiiGridView.update('class-categories-grid');
							}
						})
						return false;
				    }",
					'url'=>'Yii::app()->controller->createUrl("changeStatus",array("id"=>$data->id))',
				),
				'deactive' => array
				(
					'label'=>'غیرفعال',
					'imageUrl'=>Yii::app()->baseUrl."/images/suspend.png",
					'visible' => '$data->status == ClassCategories::STATUS_ACTIVE',
					'click'=>"function(){
						$.fn.yiiGridView.update('class-categories-grid', {
							type:'POST',
							url:$(this).attr('href'),
							success:function(data) {
								$.fn.yiiGridView.update('class-categories-grid');
							}
						})
						return false;
                    }",
					'url'=>'Yii::app()->controller->createUrl("changeStatus",array("id"=>$data->id))',
				),
			)
		),
	),
)); ?>