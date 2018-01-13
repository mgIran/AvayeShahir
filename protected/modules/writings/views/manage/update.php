<?php
/* @var $this WritingsManageController */
/* @var $model Writings */
/* @var $fileModel WritingFiles */
/* @var $fileLinkModel WritingFileLinks */
/* @var $files CActiveDataProvider */
/* @var $fileLinks CActiveDataProvider */

$this->breadcrumbs=array(
		'لیست رایتینیگ ها'=>array('admin'),
		$model->title,
		'ویرایش',
);

$this->menu=array(
		array('label'=>'لیست رایتینیگ ها', 'url'=>array('admin')),
		array('label'=>'افزودن رایتینیگ', 'url'=>array('create')),
);

?>

<h1>ویرایش رایتینیگ "<?php echo $model->title; ?>"</h1>

<div class="tab-content">
	<div id="general" class="tab-pane fade <?= !isset($_GET['step'])?'in active':'' ?>">
		<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>
	</div>
</div>