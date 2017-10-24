<?php
/* @var $this PublicController */
/* @var $model Users */
/* @var $form CActiveForm */
?>
<div class="row">
    <div class="form change-pass col-lg-6 col-md-8 col-sm-8 col-xs-12">
        <?php $this->renderPartial('//layouts/_flashMessage',array('prefix'=>'setting-'))?>
        <?php $this->renderPartial('//layouts/_loading')?>
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'change-pass-form',
            'focus'=>array($model,'oldPassword'),
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form ,data ,hasError){
                    if(!hasError)
                    {
                        var form = $("#change-pass-form");
                        var loading = $(".change-pass .loading-container");
                        var url = \''.Yii::app()->createUrl('/users/public/setting').'\';
                        submitAjaxForm(form ,url ,loading ,"if(typeof html.url == \'undefined\') location.reload(); else window.location=html.url;");
                    }
                }'
            )
        ));
        echo CHtml::hiddenField('ajax','change-pass-form');
        Yii::app()->clientScript->registerScript('resetPanelForm','
            document.getElementById("change-pass-form").reset();
            $("#Users_oldPassword").val("");
        ',CClientScript::POS_READY);
        ?>

        <div class="form-group">
            <?php echo $form->labelEx($model,'oldPassword', array('class'=>'control-label')); ?>
            <?php echo $form->passwordField($model,'oldPassword',array('class'=>'form-control','maxlength'=>100)); ?>
            <?php echo $form->error($model,'oldPassword'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'newPassword', array('class'=>'control-label')); ?>
            <?php echo $form->passwordField($model,'newPassword',array('class'=>'form-control','maxlength'=>100)); ?>
            <?php echo $form->error($model,'newPassword'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'repeatPassword', array('class'=>'control-label')); ?>
            <?php echo $form->passwordField($model,'repeatPassword',array('class'=>'form-control','maxlength'=>100)); ?>
            <?php echo $form->error($model,'repeatPassword'); ?>
        </div>

        <div class="buttons">
            <?php echo CHtml::submitButton(Yii::t('app','Change Password'),array('class'=>'btn btn-success')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>