<?php
/* @var $this MultimediaPicturesController */
/* @var $model Multimedia */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
);

$this->menu=array(
	array('label'=>'افزودن تصویر', 'url'=>array('create')),
	array('label'=>'ویرایش تصویر', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف تصویر', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت تصاویر', 'url'=>array('admin')),
);
?>

<h1>نمایش تصویر #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'title',
		array(
			'name' => 'data',
			'value' => CHtml::tag("div",
				array("style"=>"text-align: right" ) ,
				CHtml::tag("img",
					array("height"=>"50px","width"=>"50px",
						"src" => Yii::app()->getBaseUrl(true).'/uploads/multimedia/'.$model->data,"alt" => ""
					)
				)
			),
			'type' => 'raw'
		),
		'seen',
	),
)); ?>
