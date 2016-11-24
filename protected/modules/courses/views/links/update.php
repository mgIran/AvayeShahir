<?php
/* @var $this ClassCategoryFileLinksController */
/* @var $model ClassCategoryFileLinks */

$this->breadcrumbs=array(
	'ویرایش لینک',
	$model->title,
);
$this->menu = array(
	array('label' => 'بازگشت', 'url' => array('/courses/categories/update/id/'.$model->category_id.'/step/3'))
);
?>
<h1>ویرایش لینک <?php echo $model->title; ?></h1>
<ul class="nav nav-tabs">
	<li<?php echo !isset($_GET['image'])?' class="active"':''?>><a data-toggle="tab" data-target="#general" href="#">اطلاعات</a></li>
	<li<?php echo isset($_GET['image'])?' class="active"':''?>><a data-toggle="tab" data-target="#pic" href="#">تصویر</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane fade<?php echo !isset($_GET['image'])?' in active':''?>" id="general">
		<?php $this->renderPartial('_form',array('model' => $model)) ?>
	</div>
	<div class="tab-pane fade<?php echo isset($_GET['image'])?' in active':''?>" id="pic">
		<?php $this->renderPartial('_pic',array('model' => $model)) ?>
	</div>
</div>