<?php
/* @var $this MultimediaVideosController */
/* @var $model Multimedia */
/* @var $thumbnail array */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'multimedia-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo EMHelper::megaOgogo($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model,'category_id',MultimediaCategories::model()->adminSortList()); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo EMHelper::megaOgogo($model,'description',array('size'=>50),'textarea'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>


<?php
//var_dump($model->data);exit;
?>
	<div class="row">
		<label>نوع ویدئو</label>
        <div class="clearfix"></div>
		<?php echo CHtml::radioButtonList('Multimedia[type]', $model->isNewRecord?Multimedia::TYPE_VIDEO_INTERNAL:$model->type, array(
            Multimedia::TYPE_VIDEO_INTERNAL=> 'داخل سرور',
            Multimedia::TYPE_VIDEO=> 'خارج از سرور',
        )); ?>
		<?php echo $form->error($model,'data'); ?>
	</div>

    <div class="well">
    <div class='row'>
        <label>ویدئوی داخلی</label>
        <?php
        $this->widget('ext.fileManager.fileManager', array(
            'id' => 'video-file',
            'name' => 'Multimedia[video_file]',
            'url' => $this->createUrl('/multimedia/videos/fetch'),
            'maxFiles' => 1,
            'serverDir' => $this->videoPath,
            'serverFile' => $model->type==Multimedia::TYPE_VIDEO_INTERNAL?$model->data:null,
        ));
        ?>
    </div>
<hr>
	<div class="row">
		<label>کد آی فریم ویدئوی خارجی</label>
		<?php echo CHtml::textArea('Multimedia[iframe]', $model->type==Multimedia::TYPE_VIDEO?$model->data:'',array('rows' => 6,'cols'=>60,'maxlength'=>1000,'class'=>'form-control ltr text-left')); ?>
	</div>
    </div>

    <?php echo $form->error($model,'data'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'thumbnail'); ?>
		<?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderFile',
			'model' => $model,
			'name' => 'thumbnail',
			'maxFiles' => 1,
			'maxFileSize' => 2, //MB
			'url' => $this->createUrl('/multimedia/videos/upload'),
			'deleteUrl' => $this->createUrl('/multimedia/videos/deleteUpload'),
			'acceptedFiles' => '.jpeg, .jpg, .png, .gif',
			'serverFiles' => $thumbnail,
			'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.status)
					{serverName} = responseObj.fileName;
				else
					console.log(responseObj.message);
            ',
		)); ?>
		<?php echo $form->error($model,'thumbnail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formTags'); ?>
		<?php
		$this->widget("ext.tagIt.tagIt",array(
			'model' => $model,
			'attribute' => 'formTags',
			'suggestType' => 'json',
			'suggestUrl' => Yii::app()->createUrl('/courses/tags/list'),
			'data' => $model->formTags
		));
		?>
		<button data-toggle="modal" data-target="#modal" class="btn btn-success btn-round btn-inverse btn-sm">
			<i class="icon-plus icon-1x"></i>
			&nbsp;&nbsp;
			افزودن برچسب دلخواه
		</button>
		<?php echo $form->error($model,'formTags'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<div class="modal fade" role="dialog" id="modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
				<?
				$this->renderPartial('_tagForm',array(
					'model' => new ClassTags()
				)); ?>
			</div>
		</div>
	</div>
</div>