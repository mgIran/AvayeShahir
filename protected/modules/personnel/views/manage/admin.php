<?php
/* @var $this PersonnelManageController */
/* @var $model Personnel */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
		array('label'=>'لیست کارمندان', 'url'=>array('admin')),
		array('label'=>'افزودن', 'url'=>array('create')),
);

?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت کارمندان</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'personnel-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header' => 'نام کامل',
			'name' => 'fullName',
			'filter' => CHtml::activeTextField($model,'fullNameFilter')
		),
		'post',
		'email',
		'tell',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
