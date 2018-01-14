<?php
/* @var $this MultimediaPicturesController */
/* @var $model Multimedia */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن تصویر', 'url'=>array('create')),
);
?>

<h1>مدیریت تصاویر</h1>

<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
	'id'=>'multimedia-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'image',
			'header' => 'تصویر',
			'filter' => '',
			'type' => 'html',
			'value' => function($data){
				return CHtml::tag("div",
					array("style"=>"text-align: center" ) ,
					CHtml::tag("img",
						array("height"=>"50px","width"=>"50px",
							"src" => Yii::app()->getBaseUrl(true).'/uploads/multimedia/'.$data->data,"alt" => ""
						)
					)
				);
			},
		),
		'title',
		'seen',
		array(
			'class'=>'CButtonColumn'
		),
	),
)); ?>
