<?php
/* @var $this MultimediaVideosController */
/* @var $model Multimedia */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن ویدئو', 'url'=>array('create')),
);
?>

<h1>مدیریت ویدئو ها</h1>

<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
	'orderField' => 'order',
	'idField' => 'id',
	'orderUrl' => 'order',
	'allItemsInOnePage' => false,
//$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'multimedia-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => '{items} {pager}',
	'columns'=>array(
		array(
			'name' => 'thumbnail',
			'value' => function($model){
				$path = Yii::getPathOfAlias('webroot').'/uploads/multimedia/thumbnail/';
				return $model->thumbnail && is_file($path.$model->thumbnail)?CHtml::image(Yii::app()->getBaseUrl(true).'/uploads/multimedia/thumbnail/'.$model->thumbnail,'', array('style' => 'width:80px;')):'';
			},
			'type' => 'raw',
			'htmlOptions' => array('style' => 'width:50px;'),
			'filter' => false
		),
		'title',
		array(
			'name' => 'category_id',
			'value' => function($model){
				return $model->category->title;
			},
			'type' => 'raw',
			'filter' => MultimediaCategories::model()->adminSortList()
		),
		'seen',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
