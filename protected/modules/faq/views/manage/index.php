<?php
/* @var $this ManageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'FAQs',
);

$this->menu=array(
	array('label'=>'افزودن ', 'url'=>array('create')),
	array('label'=>'مدیریت ', 'url'=>array('admin')),
);
?>

<h1>پرسش و پاسخ ها</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
