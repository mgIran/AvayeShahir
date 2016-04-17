<?php
/* @var $this SiteSettingManageController */
/* @var $model SiteSetting */
?>

<div class="form">
    <?
    $form = $this->beginWidget('CActiveForm',array(
        'id'=> 'general-setting',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ));
    ?>

    <?php echo $this->renderPartial('//layouts/_flashMessage')?>

    <? foreach($model as $field) { ?>
        <div class="row">
            <div class="row">
                <?php echo CHtml::label($field->title, '', array('class' => 'col-lg-3 control-label')); ?>
                <?php echo CHtml::textarea("SiteSetting[$field->name]", $field->value, array('size' => 60, 'class' => 'col-lg-9 form-control')); ?>
                <?php echo $form->error($field, 'name'); ?>
            </div>
        </div>
        <?
    }
    ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton('ذخیره',array('class' => 'btn btn-success')); ?>
    </div>
    <?
    $this->endWidget();
    ?>
</div>