<?php
/* @var $this OrdersManageController */
/* @var $model Orders */
/* @var $form CActiveForm */
/* @var $filesArray [] */
?>
<h3 class="bordered"><?= Yii::t('app', 'Send Order')?></h3>
<div class="form-bg">
    <?
    if(Yii::app()->user->isGuest || Yii::app()->user->type == 'admin'):
        echo '<h3>'.Yii::t('app', 'For add new order should be signed up.');
        echo '<a data-toggle="modal" href="#login-modal">'.Yii::t('app', 'Log In').'</a>';
        echo '&nbsp;'.Yii::t('app','or').'&nbsp;';
        echo '<a target="_blank" href="'.Yii::app()->baseUrl.'/#signup'.'">'.Yii::t('app', 'Sign Up.').'</a></h3>';
        echo '<div class="form-group">
                <a class="btn btn-info"
                   href="'.Yii::app()->getBaseUrl(true).'">'.Yii::t('app', 'Back') .'</a>
            </div>';
    else:
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
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group">
                    <?php echo $form->labelEx($model,'title'); ?>
                    <?php echo $form->textField($model,'title',array('class' => 'form-control','size'=>50,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'title'); ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group">
                    <?php echo $form->labelEx($model,'category_id'); ?>
                    <?php echo $form->dropDownList($model,'category_id',CHtml::listData(OrderCategories::validCategories(),'id','title'),array(
                        'class' => 'form-control',
                        'prompt' => '-'
                    )); ?>
                    <?php echo $form->error($model,'category_id'); ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group">
                    <?php echo $form->labelEx($model,'order_priority'); ?>
                    <?php echo $form->dropDownList($model,'order_priority', $model->getOrderPriorityLabels(), array(
                        'class' => 'form-control'
                    )); ?>
                    <?php echo $form->error($model,'order_priority'); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'files'); ?>
                <?php
                $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                    'id' => 'uploaderPic',
                    'model' => $model,
                    'name' => 'files',
                    'maxFiles' => 5,
                    'maxFileSize' => 10, //MB
                    'url' => Yii::app()->createUrl('/orders/public/upload'),
                    'deleteUrl' => Yii::app()->createUrl('/orders/public/deleteUpload'),
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

            <div class="form-group">
                <?php echo $form->labelEx($model,'description'); ?>&nbsp;<small>(<?= Yii::t('app', 'max: 1024 characters') ?>)</small>
                <?php echo $form->textArea($model,'description',array('class' => 'form-control','rows'=>5,'maxlength'=>1024)); ?>
                <?php echo $form->error($model,'description'); ?>
            </div>

            <div class="form-group buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Send') : Yii::t('app', 'Update'),array('class' => 'btn btn-success pull-left')); ?>
            </div>

        <?php $this->endWidget(); ?>
        </div>
        <?php
    endif;
?>