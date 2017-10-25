<?php
/* @var $this OrdersManageController */
/* @var $order Orders */
/* @var $model OrderFiles */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'add-file-order-form',
    'action' => array('manage/addFile/'.$order->id),
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form ,data ,hasError){
			if(!hasError)
			{
				var form = $("#add-file-order-form");
				var loading = $("#add-file-order-form .loading-container");
				var url = \''.Yii::app()->createUrl('/orders/manage/addFile/'.$order->id).'\';
				submitAjaxForm(form ,url ,loading ,"location.reload();");
				$("#close-add-modal").click();
				$.fn.yiiGridView.update(\'orders-project-files-grid\');
			}
		}'
    )
)); ?>

    <?php $this->renderPartial('//layouts/_loading'); ?>
    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)) ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'filename'); ?>
        <?php
        $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'uploaderPic',
            'model' => $model,
            'name' => 'filename',
            'maxFiles' => 1,
            'maxFileSize' => 10, //MB
            'url' => Yii::app()->createUrl('/orders/manage/uploadFile'),
            'deleteUrl' => Yii::app()->createUrl('/orders/manage/deleteUpload'),
            'acceptedFiles' => Orders::$acceptedFiles,
            'serverFiles' => [],
            'onSuccess' => '
                var responseObj = JSON.parse(res);
				if(responseObj.status){
					{serverName} = responseObj.fileName;
					$(".uploader-message").html("");
				}
				else{
					$(".uploader-message").html(responseObj.message);
                    this.removeFile(file);
                }
            ',
        ));
        ?>
        <?php echo $form->error($model,'filename'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('افزودن',array('class' => 'btn btn-success')); ?>
        <button type="button" data-dismiss="modal" id="close-add-modal" class="btn btn-default pull-left">انصراف</button>
    </div>

<?php $this->endWidget(); ?>

<style>
    .dropzone.single{
        width: auto;
    }
</style>
