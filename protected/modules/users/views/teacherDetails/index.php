<?php
/* @var $this TeacherDetailsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Teacher Details',
);

$this->menu=array(
	array('label'=>'Create TeacherDetails', 'url'=>array('create')),
	array('label'=>'Manage TeacherDetails', 'url'=>array('admin')),
);
?>

<h1>Teacher Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
