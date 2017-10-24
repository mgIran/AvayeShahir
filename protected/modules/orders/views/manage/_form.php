<?php
/* @var $this OrdersManageController */
/* @var $model Orders */
/* @var $form CActiveForm */
/* @var $filesArray [] */
?>
<?php $this->renderPartial("//layouts/_flashMessage"); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orders-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true
	)
)); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'user_id'); ?>
        <?php echo $form->dropDownList($model, 'user_id', CHtml::listData(Users::model()->findAll('role_id = 1'), 'id', 'userDetails.fullName'),array(
            'class' => 'selectpicker',
            'data-live-search' => true,
        )); ?>
        <a href="#new-user-modal" data-toggle="modal" class="btn btn-success"><span class="icon icon-plus">&nbsp;&nbsp;</span><span class="icon icon-user"></span></a>
        <?php echo $form->error($model, 'user_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'category_id'); ?>
        <?php echo $form->dropDownList($model,'category_id',CHtml::listData(OrderCategories::validCategories(),'id','title'),array(
            'prompt' => '-',
            'id' => 'category_id'
        )); ?>
        <?php echo $form->error($model,'category_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'order_priority'); ?>
        <?php echo $form->dropDownList($model,'order_priority', $model->orderPriorityLabels); ?>
        <?php echo $form->error($model,'order_priority'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_price'); ?>
		<?php echo $form->textField($model,'order_price',array('size'=>10,'maxlength'=>10)); ?> تومان
		<?php echo $form->error($model,'order_price'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'files'); ?>
        <?php
        $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'uploaderPic',
            'model' => $model,
            'name' => 'files',
            'maxFiles' => 5,
            'maxFileSize' => 10, //MB
            'url' => Yii::app()->createUrl('/orders/manage/upload'),
            'deleteUrl' => Yii::app()->createUrl('/orders/manage/deleteUpload'),
            'acceptedFiles' => Orders::$acceptedFiles,
            'serverFiles' => $filesArray,
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
        <?php echo $form->error($model,'files'); ?>
        <div class="uploader-message error"></div>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>5,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

<div class="modal fade" role="dialog" id="new-user-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">&times;</button>
                <h3>افزودن کاربر</h3>
            </div>
            <div class="modal-body">
                <? $this->renderPartial('users.views.manage._ajax_form',array('model' => new Users('ajaxInsert'))); ?>
            </div>
        </div>
    </div>
</div>
