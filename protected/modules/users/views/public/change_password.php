<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><?= Yii::t('app','Change Password')?></h2>
    </div>
</div>
<div class="page-content forgot">

    <div class="container">
        <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12 col-lg-pull-2 col-md-pull-2 col-sm-pull-1 col-lg-push-2 col-md-push-2 col-sm-push-1">

            <div class="tab-content">
                <?= $this->renderPartial("//layouts/_flashMessage");?>
                <?
                if($model):
                ?>
                <div id="general-tab" class="tab-pane fade active in">
                    <?= $this->renderPartial("//layouts/_loading");?>
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'users-form',
                        'enableAjaxValidation'=>true,
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                            'beforeValidate' => "js:function(form) {
                                $('.loading-container').fadeIn();
                                return true;
                            }",
                            'afterValidate' => "js:function(form) {
                                $('.loading-container').stop().hide();
                                return true;
                            }",
                        ),
                    ));?>
                    <div class="form-group">
                        <?php echo CHtml::passwordField('Users[password]','',array('class'=>'form-control','placeholder'=>Yii::t('app','Password'))); ?>
                    </div>
                    <div class="form-group">
                        <?php echo CHtml::passwordField('Users[repeatPassword]','',array('class'=>'form-control','placeholder'=>Yii::t('app','Repeat Password'))); ?>
                    </div>
                    <div class="form-group">
                        <?php echo CHtml::SubmitButton(Yii::t('app','Save'), array('class'=>'btn btn-success'));?>
                        <a class="btn btn-info" href="#login-modal" data-toggle="modal"><?= Yii::t('app','Login to Account') ?></a>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <?
                else:
                ?>
                <a class="btn btn-info" href="#login-modal" data-toggle="modal"><?= Yii::t('app','Login to Account') ?></a>
                <?
                endif;
                ?>
            </div>
        </div>
    </div>
</div>