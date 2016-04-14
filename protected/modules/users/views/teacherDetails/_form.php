<?php
/* @var $this TeacherDetailsController */
/* @var $model TeacherDetails */
/* @var $form CActiveForm */
/* @var $avatar string */
/* @var $file string */
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'teacher-details-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'avatar'); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
				'id' => 'uploaderPic',
				'model' => $model,
				'name' => 'avatar',
				'maxFiles' => 1,
				'maxFileSize' => 1, //MB
				'url' => Yii::app()->createUrl('/users/teacherDetails/upload'),
				'deleteUrl' => Yii::app()->createUrl('/users/teacherDetails/deleteUpload'),
				'acceptedFiles' => 'image/jpeg , image/png',
				'serverFiles' => $avatar,
				'onSuccess' => '
			var responseObj = JSON.parse(res);
			if(responseObj.state == "ok")
			{
				{serverName} = responseObj.fileName;
			}else if(responseObj.state == "error"){
				console.log(responseObj.msg);
			}',
		));
		?>
		<?php echo $form->error($model,'avatar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'family'); ?>
		<?php echo $form->textField($model,'family',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'family'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'grade'); ?>
		<?php echo $form->textField($model,'grade',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'grade'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'tell'); ?>
		<?php echo $form->textField($model,'tell',array('size'=>50,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'tell'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>6)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'social_links'); ?>
		<div class="dynamic-box">
		<?
		if($model->social_links):
			$social_links = CJSON::decode($model->social_links);
			// face book & twitter links are constant
		?>
				<div class="dynamic-field input-group">
					<div class="label">فیسبوک : </div>
					<div class="input">
						<?= CHtml::textField('TeacherDetails[social_links][0][value]',(isset($social_links[0])?$social_links[0]['value']:''),array('class'=>'form-control','placeholder'=>'آدرس لینک')); ?>
					</div>
				</div>
				<div class="dynamic-field input-group">
					<div class="label">توییتر : </div>
					<div class="input">
						<?= CHtml::textField('TeacherDetails[social_links][1][value]',(isset($social_links[1])?$social_links[1]['value']:''),array('class'=>'form-control','placeholder'=>'آدرس لینک')); ?>
					</div>
				</div>
		<?
			unset($social_links[0]);
			unset($social_links[1]);
			// any social links are dynamic
			foreach($social_links as $key => $link):
				?>
				<div class="dynamic-field input-group">
					<div class="label">
						<?= CHtml::textField("TeacherDetails[social_links][$key][title]",$link['title'],array('class'=>'form-control')); ?>
					</div>
					<div class="input">
						<?= CHtml::textField("TeacherDetails[social_links][$key][value]",$link['value'],array('class'=>'form-control')); ?>
					</div>
				</div>
			<?
			endforeach;
		else:
			?>
			<div class="dynamic-field input-group">
				<div class="label">فیسبوک : </div>
				<div class="input">
					<?= CHtml::textField('TeacherDetails[social_links][0][value]','',array('class'=>'form-control' ,'placeholder'=>'آدرس لینک')); ?>
				</div>
			</div>
			<div class="dynamic-field input-group">
				<div class="label">توییتر : </div>
				<div class="input">
					<?= CHtml::textField('TeacherDetails[social_links][1][value]','',array('class'=>'form-control','placeholder'=>'آدرس لینک')); ?>
				</div>
			</div>
			<?
		endif;
		?>
		</div>
		<div class="operation-links">
			<a class="icon icon-plus icon-2x add-dynamic-field-trigger"></a>
			<a class="icon icon-trash remove-dynamic-field-trigger"></a>
		</div>
		<?php echo $form->error($model,'social_links'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'resume'); ?>
		<?
		$this->widget('ext.ckeditor.CKEditor',array(
				'model' => $model,
				'attribute'=>'resume'
		));
		?>
		<?php echo $form->error($model,'resume'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'file'); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
				'id' => 'uploaderFile',
				'model' => $model,
				'name' => 'file',
				'maxFiles' => 1,
				'maxFileSize' => 5, //MB
				'url' => Yii::app()->createUrl('/users/teacherDetails/uploadFile'),
				'deleteUrl' => Yii::app()->createUrl('/users/teacherDetails/deleteUploadFile'),
				'acceptedFiles' => 'application/pdf ,application/word',
				'serverFiles' => $file,
				'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.state == "ok")
				{
					{serverName} = responseObj.fileName;
				}else if(responseObj.state == "error"){
					console.log(responseObj.msg);
				}',
		));
		?>
		<?php echo $form->error($model,'file'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?
Yii::app()->clientScript->registerScript('dynamic-fields','
		var $dynamicFieldsNum = $(".dynamic-field").length;
		$(\'.add-dynamic-field-trigger\').click(function () {
			var box = $(this).parents(".row").find(".dynamic-box");
			$dynamicFieldsNum++;
			box.append("<div class=\'dynamic-field input-group\'>" +
				"<div class=\'label\'>" +
					"<input type=\'text\' name=\'"+"TeacherDetails[social_links]["+$dynamicFieldsNum+"][title]"+"\' class=\'form-control\' placeholder=\'عنوان شبکه اجتماعی\' >" +
				"</div>" +
				"<div class=\'input\'>" +
					"<input type=\'text\' name=\'"+"TeacherDetails[social_links]["+$dynamicFieldsNum+"][value]"+"\' class=\'form-control\' placeholder=\'آدرس لینک\' >" +
				"</div> " +
			"</div>");
		});
		$(\'.remove-dynamic-field-trigger\').click(function () {
			if($dynamicFieldsNum > 2)
			{
				var box = $(this).parents(".row").find(".dynamic-box");
				box.find(".dynamic-field:last-child").remove();
				$dynamicFieldsNum--;
			}
		});
');