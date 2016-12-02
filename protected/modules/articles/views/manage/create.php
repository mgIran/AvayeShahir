<?php
/* @var $this ArticlesManageController */
/* @var $model Articles */

$this->breadcrumbs=array(
	'لیست مطالب'=>array('admin'),
	'افزودن مطلب',
);
$this->menu=array(
	array('label'=>'لیست مطالب', 'url'=>array('admin')),
);
if(isset($_GET['return']) && $_GET['return'] == true)
	$this->menu = array(
		array('label'=>'بازگشت', 'url'=>Yii::app()->user->returnUrl)
	);
?>

<h1>افزودن مطلب</h1>
<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#general">عمومی</a></li>
	<li class="disabled"><a href="#">آپلود فایل</a></li>
	<li class="disabled"><a href="#">لینک فایل</a></li>
	<li class="disabled"><a href="#">لینک خارجی</a></li>
</ul>

<div class="tab-content">
	<div id="general" class="tab-pane fade in active">
		<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>
	</div>
</div>