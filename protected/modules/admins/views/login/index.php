<?
/* @var $this LoginController */
/* @var $model AdminLoginForm */
/* @var $form CActiveForm */
?>
<div class="col-lg-12" align="center">
    <h1>
        ورود به مدیریت
    </h1>
    <div class="form">
        <?php
        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'login-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )); ?>
        <div class="row form-group">
            <?php echo $form->textField($model,'username',array('class'=>'transition focus-left','placeholder'=>'نام کاربری')); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>
        <div class="row form-group">
            <?php echo $form->passwordField($model,'password',array('class'=>'transition','placeholder'=>'رمز عبور')); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>
        <?php if ($model->scenario == 'withCaptcha' && CCaptcha::checkRequirements()): ?>
            <div class="row form-group">
                <?php echo $form->labelEx($model, 'verifyCode'); ?>
                <div>
                    <?php $this->widget('CCaptcha'); ?>
                    <?php echo $form->textField($model, 'verifyCode'); ?>
                </div>
                <?php echo $form->error($model, 'verifyCode'); ?>
            </div>
        <?php endif; ?>
        <div class="row form-group">
            <?php echo CHtml::submitButton('ورود',array('class' => 'btn btn-success')); ?>
        </div>
        <?php $this->endWidget(); ?>
        <p>
<!--            <a href="#" class="forget-link">-->
<!--                رمز عبور خود را فراموش کرده اید؟-->
<!--            </a>-->
        </p>
    </div>
</div>

<script>
    $(function () {
        $("#yw0_button").click();
    });
</script>