<?php
/* @var $this SlideshowManageController */
/* @var $model Slideshow */
$this->breadcrumbs=array(
		'لیست تصاویر',
);

$this->menu=array(
		array('label'=>'لیست تصاویر', 'url'=>array('admin')),
		array('label'=>'افزودن تصاویر', 'url'=>array('create')),
);

?>

<h1>لیست تصاویر</h1>
<p>* جهت تغییر ترتیب نمایش تصاویر، ردیف ها را جابجا کنید.</p>
<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'dataProvider'=>$model->search(),
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
	'id'=>'slideshow-grid',
//	'filter'=>$model,
	'itemsCssClass'=>'table table-striped',
	'columns'=>array(
		array(
			'name' => 'image',
			'value' => function($data){
				return CHtml::image(Yii::app()->getBaseUrl(true).'/uploads/slideshow/'.$data->image,$data->image, array('style' => 'width:100px;height:auto'));
			},
			'htmlOptions' => array('style' => 'width:120px;height:auto;'),
			'filter' => false,
			'type' => 'raw'
		),
		array(
			'name' => 'status',
			'value' => function($data){
				return CHtml::label($data->statusLabels[$data->status],'',array('class' => 'label label-'.($data->status?'success':'danger')));
			},
			'type' => 'raw',
			'filter' => CHtml::activeDropDownList($model,'status',$model->statusLabels,array('prompt' => '-'))
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update} {changeStatus} {delete}',
			'htmlOptions' => array('style' => 'width:150px'),
			'buttons' => array(
				'changeStatus' => array(
					'label' => 'تغییر وضعیت',
					'imageUrl' => false,
					'options' => array('class' => 'btn btn-warning btn-xs'),
					'url' => 'Yii::app()->controller->createUrl("manage/changeStatus/".$data->id)'
				),
				'delete' =>array(
					'label' => 'حذف',
					'imageUrl' => false,
					'options' => array('class' => 'btn btn-danger btn-xs')
				)
			)
		),
	),
)); ?>
