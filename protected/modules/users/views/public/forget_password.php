
<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><?= Yii::t('app','Forget Password')?></h2>
    </div>
</div>
<div class="page-content forgot">

    <div class="container">
        <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12 col-lg-pull-2 col-md-pull-2 col-sm-pull-1 col-lg-push-2 col-md-push-2 col-sm-push-1">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a><?= Yii::t('app','Recover Password')?></a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="general-tab" class="tab-pane fade active in">
                    <?= $this->renderPartial("//layouts/_loading");?>
                    <?php echo CHtml::beginForm(Yii::app()->createUrl('/users/public/forgetPassword'), 'post', array(
                        'id'=>'forget-password-form',
                        'class' => 'form-group'
                    ));?>
                    <div class="alert alert-success hidden" id="message"></div>
                    <div class="form-group">
                        <?php echo CHtml::emailField('email' ,'' ,array(
                            'placeholder' => Yii::t('app','Email'),
                            'class' => 'form-control'
                        ));
                        ?>
                    </div>
                    <div class="relative">
                        <?php echo CHtml::ajaxSubmitButton('ارسال', Yii::app()->createUrl('/users/public/forgetPassword'), array(
                            'type'=>'POST',
                            'dataType'=>'JSON',
                            'data'=>"js:$('#forget-password-form').serialize()",
                            'beforeSend'=>"js:function(){
                    $('#message').addClass('hidden');
                    $('.loading-container').fadeIn();
                }",
                            'success'=>"js:function(data){
                    if(data.hasError)
                        $('#message').removeClass('alert-success').addClass('alert-danger message visible').text(data.message).removeClass('hidden');
                    else
                        $('#message').removeClass('alert-danger').addClass('alert-success message visible').text(data.message).removeClass('hidden');
                    $('.loading-container').fadeOut();
                }"
                        ), array('class'=>'btn btn-success'));?>
                    </div>
                    <?php CHtml::endForm(); ?>
                </div>
                </div>
            </div>
        </div>
    </div>
