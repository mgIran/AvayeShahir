<?php 
/**
 * @var $newComment Comment
 */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->postCommentAction),
        'id'=>$this->id,
)); ?>
    <?php 
        echo $form->hiddenField($newComment, 'owner_name'); 
        echo $form->hiddenField($newComment, 'owner_id'); 
        echo $form->hiddenField($newComment, 'parent_comment_id', array('class'=>'parent_comment_id'));
    ?>
    <?php if(Yii::app()->user->isGuest == true):?>
        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->textField($newComment,'user_name', array('size'=>40 ,'class'=>'form-control','placeholder' => $newComment->getAttributeLabel('user_name'))); ?>
            <?php echo $form->error($newComment,'user_name'); ?>
        </div>
        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->textField($newComment,'user_email', array('size'=>40,'class'=>'form-control','placeholder' => $newComment->getAttributeLabel('user_email'))); ?>
            <?php echo $form->error($newComment,'user_email'); ?>
        </div>
    <?php endif; ?>

    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php echo $form->textArea($newComment, 'comment_text', array('cols' => 60, 'rows' => 5,'class'=>'form-control','placeholder' => $newComment->getAttributeLabel('comment_text'))); ?>
        <?php echo $form->error($newComment, 'comment_text'); ?>
    </div>

    <?php if($this->useCaptcha === true && extension_loaded('gd')): ?>
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div>
                <div class="captcha-box">
                    <?php $this->widget('CCaptcha', array(
                        'captchaAction'=>CommentsModule::CAPTCHA_ACTION_ROUTE,
                        'showRefreshButton' => true
                    )); ?>
                </div>
                <?php echo $form->textField($newComment,'verifyCode',array('class' => 'form-control','placeholder' => $newComment->getAttributeLabel('verifyCode'))); ?>
                
            </div>
            <div class="hint">
                <?php echo Yii::t('CommentsModule.msg', 'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.');?>
            </div>
            <?php echo $form->error($newComment, 'verifyCode'); ?>
        </div>
    <?php endif; ?>

    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php echo CHtml::ajaxSubmitButton(Yii::t('CommentsModule.msg','Add comment'),Yii::app()->createUrl($this->postCommentAction),array(
                'data' => 'js:$("#'.$this->id.'").serialize()',
                'type' => 'POST',
                'dataType' => 'json',
                'success' => 'js:function(data){
                    $("#'.$this->id.'").html(data.form);
                    if(data.code == "success")
                    {
                        var list = $("#'.$this->id.'").parents(\'.comment-widget\');
                        list.html($(data.list).html());
                    }
                }'
            ),array('class'=> 'btn btn-success pull-left'));
        ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->
