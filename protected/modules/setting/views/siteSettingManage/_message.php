<?php
/* @var $this SiteSettingManageController */
/* @var $model SiteSetting */
?>

<div class="form">
    <?
    $form = $this->beginWidget('CActiveForm',array(
        'id'=> 'site-message',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ));
    ?>

    <?php echo $this->renderPartial('//layouts/_flashMessage')?>
    <? foreach($model as $field) { ?>
        <? if($field->name == 'message'): ?>
            <div class="row">
                <div class="row">
                    <?php echo CHtml::label($field->title, '', array('class' => 'col-lg-3 control-label')); ?>
                    <?php echo CHtml::textarea("SiteSetting[$field->name]", $field->value, array('rows' => 10, 'class' => 'col-lg-9')); ?>
                    <?php echo $form->error($field, 'name'); ?>
                </div>
            </div>
            <?
        elseif($field->name == 'message_en'): ?>
            <div class="row">
                <div class="row">
                    <?php echo CHtml::label($field->title, '', array('class' => 'col-lg-3 control-label')); ?>
                    <?php echo CHtml::textarea("SiteSetting[$field->name]", $field->value, array('rows' => 10, 'class' => 'col-lg-9')); ?>
                    <?php echo $form->error($field, 'name'); ?>
                </div>
            </div>
            <?
        elseif($field->name == 'message_state'):
        ?>
            <div class="row">
                <div class="row">
                    <?php echo CHtml::label($field->title, '', array('class' => 'col-lg-3 control-label')); ?>
                    <?php echo CHtml::dropDownList("SiteSetting[$field->name]", $field->value ,array(
                        0 => 'غیر فعال',
                        1 => 'فعال'
                    )); ?>
                    <?php echo $form->error($field, 'name'); ?>
                </div>
            </div>
    <?
        endif;
    }
    ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('ذخیره',array('class' => 'btn btn-success')); ?>
    </div>
    <?
    $this->endWidget();
    ?>
</div>