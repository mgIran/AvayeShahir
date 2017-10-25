<?php
/* @var $this OrdersManageController */
/* @var $settings array */
/* @var $form CActiveForm */
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">تنظیمات بخش سفارشات</h3>
    </div>
    <div class="box-body">
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
                <?php echo CHtml::label('شماره تماس دریافت کنندگان اطلاعیه', ''); ?>
                <?php
                $this->widget("ext.tagIt.tagIt",array(
                    'name' => 'OrdersSetting[phones]',
                    'data' => $settings['phones']
                ));
                ?>
                <p class="description">پس از ارسال سفارش جدید یا پرداخت هزینه سفارش برای شماره همراه های فوق پیامک ارسال میشود.</p>
            </div>

            <div class="row">
                <?php echo CHtml::label('پست الکترونیک دریافت کنندگان اطلاعیه', ''); ?>
                <?php
                $this->widget("ext.tagIt.tagIt",array(
                    'name' => 'OrdersSetting[emails]',
                    'data' => $settings['emails']
                ));
                ?>
                <p class="description">پس از ارسال سفارش جدید یا پرداخت هزینه سفارش برای آدرس پست الکترونیکی های فوق ایمیل ارسال میشود.</p>
            </div>

            <div class="row buttons">
                <?php echo CHtml::submitButton('ذخیره',array('class' => 'btn btn-success')); ?>
            </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
