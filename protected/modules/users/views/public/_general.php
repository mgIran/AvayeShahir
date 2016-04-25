<?php
/* @var $this PublicController */
/* @var $model UserDetails */
/* @var $form CActiveForm */
?>

<?php $this->renderPartial('//layouts/_flashMessage',array('prefix'=>'general-'))?>

<div class="form general-setting">
    <?php $this->renderPartial('//layouts/_loading')?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-details-form',
        'focus'=>array($model,'name'),
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form ,data ,hasError){
                if(!hasError)
                {
                    var form = $("#user-details-form");
                    var loading = $(".general-setting .loading-container");
                    var url = \''.Yii::app()->createUrl('/users/public/update').'\';
                    submitAjaxForm(form ,url ,loading ,"if(typeof html.url == \'undefined\') location.reload(); else window.location=html.url;");
                }
            }'
        )
    ));
    echo CHtml::hiddenField('ajax','user-details-form');
    ?>

    <div class="form-group">
        <?php echo $form->textField($model,'name',array('placeholder'=>$model->getAttributeLabel('name').' *','class'=>'form-control','maxlength'=>50)); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->textField($model,'family',array('placeholder'=>$model->getAttributeLabel('family').' *','class'=>'form-control','maxlength'=>50)); ?>
        <?php echo $form->error($model,'family'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->textField($model,'phone',array('placeholder'=>$model->getAttributeLabel('phone'),'class'=>'form-control','maxlength'=>11)); ?>
        <?php echo $form->error($model,'phone'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->textField($model,'web_url',array('placeholder'=>$model->getAttributeLabel('web_url'),'class'=>'form-control','maxlength'=>100)); ?>
        <?php echo $form->error($model,'web_url'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->textField($model,'national_code',array('placeholder'=>$model->getAttributeLabel('national_code'),'class'=>'form-control','maxlength'=>10)); ?>
        <?php echo $form->error($model,'national_code'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->textField($model,'zip_code',array('placeholder'=>$model->getAttributeLabel('zip_code'),'class'=>'form-control','maxlength'=>10)); ?>
        <?php echo $form->error($model,'zip_code'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->textArea($model,'address',array('placeholder'=>$model->getAttributeLabel('address'),'class'=>'form-control')); ?>
        <?php echo $form->error($model,'address'); ?>
    </div>
    <div class="buttons">
        <?php echo CHtml::submitButton(Yii::t('app','Save'),array('class'=>'btn btn-lg btn-success')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->