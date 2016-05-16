<?php
/* @var $this ClassCategoriesManageController */
/* @var $model Gallery */
/* @var $image [] */
/* @var $form CActiveForm */
?>
<div class="form">
	<?= $this->renderPartial("//layouts/_flashMessage");?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'gallery-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
//		'afterValidate' => 'js:function(form ,data ,hasError){
//			if(!hasError)
//			{
//				var form = $("#gallery-form");
//				var loading = $("#gallery-form .loading-container");
//				var url = \''.($model->isNewRecord?Yii::app()->createUrl('/gallery/manage/create'):Yii::app()->createUrl('/gallery/manage/update')).'\';
//				submitAjaxForm(form ,url ,loading ,"if(typeof html.url == \'undefined\') location.reload(); else window.location=html.url;");
//			}
//		}'
	),
));
?>
	<?= $this->renderPartial("//layouts/_loading");?>
	<div class='row'>
		<?php echo $form->labelEx($model,'title', array('class'=>'control-label')); ?>
		<?php echo EMHelper::megaOgogo($model, 'title',array('class'=> 'span7 pull-right')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	<div class='row'>
		<?php echo $form->labelEx($model,'desc', array('class'=>'control-label')); ?>
		<?php echo EMHelper::megaOgogo($model, 'desc',array('rows'=>5,'class'=> 'span7 pull-right'),'textarea'); ?>
		<?php echo $form->error($model,'desc'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($model,'file_name', array('class'=>'control-label')); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderFile',
			'model' => $model,
			'name' => 'file_name',
			'maxFiles' => 1,
			'maxFileSize' => 3, //MB
			'url' => Yii::app()->createUrl('/gallery/manage/upload'),
			'deleteUrl' => Yii::app()->createUrl('/gallery/manage/deleteUpload'),
			'acceptedFiles' => '.jpeg, .jpg, .png, .gif',
			'serverFiles' => $image,
			'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.state == "ok")
				{
					{serverName} = responseObj.fileName;
				}else if(responseObj.state == "error"){
					console.log(responseObj.msg);
				}
		',
		));
		?>
		<?php echo $form->error($model,'file_name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->