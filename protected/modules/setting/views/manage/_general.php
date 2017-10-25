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
        <? if($field->name != 'message' &&
            $field->name != 'message_state' &&
            $field->name != 'message_en'&&
            $field->name != 'order_receivers_phones'&&
            $field->name != 'order_receivers_emails'): ?>
        <div class="row">
            <div class="row">
                <?php echo CHtml::label($field->title, '', array('class' => 'col-lg-3 control-label')); ?>
                <?php
                if($field->name=='keywords'){
                    $this->widget("ext.tagIt.tagIt",array(
                        'model' => $field,
                        'attribute' => $field->name,
                        'data' => explode(',',$field->value)
                    ));
                }else
                    echo CHtml::textarea("SiteSetting[$field->name]", $field->value, array('size' => 60, 'class' => 'col-lg-9'));
                ?>
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