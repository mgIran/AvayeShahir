<?php
/* @var $this WritingsManageController */
/* @var $model Writings */

$this->breadcrumbs=array(
	'لیست رایتینیگ ها'=>array('admin'),
	'افزودن رایتینیگ',
);
$this->menu=array(
	array('label'=>'لیست رایتینیگ ها', 'url'=>array('admin')),
	array('label'=>'افزودن گروه رایتینیگ', 'url'=>array('/writings/category/create')),
);
if(isset($_GET['return']) && $_GET['return'] == true)
	$this->menu = array(
		array('label'=>'بازگشت', 'url'=>Yii::app()->user->returnUrl)
	);
?>

<h1>افزودن رایتینیگ</h1>

<div class="tab-content">
	<div id="general" class="tab-pane fade in active">
		<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>
	</div>
</div>