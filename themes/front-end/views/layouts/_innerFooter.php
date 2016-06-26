<footer class="footer">
    <div class="container">
        <div class="info-box">
            <div class="col-md-4">
                <p>
                    <i class="map-point"></i>
                    <span>تهران: خیابان شهید بهشتی، خ سرافراز (قائم مقام فراهانی)، کوچه دهم، پلاک 9، واحد 1
</span>
                </p>
                <p>
                    <i class="phone"></i>
                    <span class="phone-number">021 88730902 - 021 88736668 - 021 88502049</span>
                </p>
                <p>
                    <i class="email"></i>
                    <span>pardis@avayeshahir.com</span>
                </p>
            </div>
            <div class="col-md-4">
                <h4><?= Yii::t('app','Visit Statistics') ?></h4>
                <div class="report">

                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <span class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <?= Yii::t('app','Online Visitors') ?>
                        </span>
                        <span class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <?php echo Yii::app()->language=='fa'?Controller::parseNumbers(Yii::app()->userCounter->getOnline()):Yii::app()->userCounter->getOnline(); ?>
                        </span>
                    </span>
                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <span class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <?= Yii::t('app','Visits Today') ?>
                        </span>
                        <span class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <?php echo Yii::app()->language=='fa'?Controller::parseNumbers(Yii::app()->userCounter->getToday()):Yii::app()->userCounter->getToday(); ?>
                        </span>
                    </span>
                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <span class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <?= Yii::t('app','Visits Yesterday') ?>
                        </span>
                        <span class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <?php echo Yii::app()->language=='fa'?Controller::parseNumbers(Yii::app()->userCounter->getYesterday()):Yii::app()->userCounter->getYesterday(); ?>
                        </span>
                    </span>
                    <!--                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">-->
                    <!--                        <span class="col-md-9">-->
                    <!--                            --><?//= Yii::t('app','Maximal Visits') ?>
                    <!--                        </span>-->
                    <!--                        <span class="col-md-3">-->
                    <!--                            --><?php //echo Yii::app()->language=='fa'?Controller::parseNumbers(Yii::app()->userCounter->getTotal()):Yii::app()->userCounter->getMaximal(); ?>
                    <!--                        </span>-->
                    <!--                    </span>-->
                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <span class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <?= Yii::t('app','All Visits') ?>
                        </span>
                        <span class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <?php echo Yii::app()->language=='fa'?Controller::parseNumbers(Yii::app()->userCounter->getTotal()):Yii::app()->userCounter->getTotal(); ?>
                        </span>
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <?= $this->renderPartial('//layouts/_map'); ?>
            </div>
            <p class="copyright"><?= Yii::t('app','All Rights Reserved By Pardis-e Avaye Shahir. ©‏') ?>&nbsp;<?= Yii::app()->language=='fa'?'1394':'2016'; ?></p>
        </div>
    </div>
</footer>
<!---->
<!--<div id="signup-modal" class="modal fade" role="dialog">-->
<!--    <div class="modal-dialog">-->
<!--        --><?//= $this->renderPartial("//layouts/_loading");?>
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close btn" data-dismiss="modal">-->
<!--                    &times;</button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                <div class="center-block box">-->
<!--                    <h3>--><?//= Yii::t('app','Sign Up Account') ?><!--</h3>-->
<!---->
<!--                    --><?php
//                    $signUpModel = new Users('agreeTerms');
//                    $form=$this->beginWidget('CActiveForm', array(
//                        'id'=>'register-form',
//                        'enableAjaxValidation'=>false,
//                        'enableClientValidation'=>true,
//                        'clientOptions'=>array(
//                            'validateOnSubmit'=>true,
//                            'afterValidate' => 'js:function(form ,data ,hasError){
//                                if(!hasError)
//                                {
//                                    var form = $("#register-form");
//                                    var loading = $(".signup .loading-container");
//                                    var url = \''.Yii::app()->createUrl('/register').'\';
//                                    submitAjaxForm(form ,url ,loading ,"if(html.state == \'ok\') location.reload();");
//                                }
//                            }'
//                        ),
//                        'htmlOptions' => array(
//                            'class' => 'form-group'
//                        )
//                    ));
//                    Yii::app()->clientScript->registerScript('registerForm','
//                        document.getElementById("register-form").reset();
//                    ');
//                    echo CHtml::hiddenField('ajax','register-form');
//                    ?>
<!--                        --><?//= $this->renderPartial("//layouts/_flashMessage");?>
<!--                        <div class="relative">-->
<!--                            --><?php //echo $form->emailField($signUpModel,'email' ,array(
//                                'placeholder' => Yii::t('app','Email'),
//                                'class' => 'text-field'
//                            ));
//                            echo $form->error($signUpModel,'email',array('class'=>'errorMessage tip'));?>
<!--                        </div>-->
<!--                        <div class="relative">-->
<!--                            --><?php //echo $form->passwordField($signUpModel,'password',array(
//                                'placeholder' => Yii::t('app','Password'),
//                                'class' => 'text-field'
//                            ));
//                            echo $form->error($signUpModel,'password',array('class'=>'errorMessage tip'));?>
<!--                        </div>-->
<!--                        <div class="relative">-->
<!--                            --><?php //echo $form->telField($signUpModel,'phone',array(
//                                'placeholder' => Yii::t('app','Phone'),
//                                'class' => 'text-field',
//                                'max-length' => 11
//                            ));
//                            echo $form->error($signUpModel,'phone',array('class'=>'errorMessage tip'));?>
<!--                        </div>-->
<!--                        <div class="relative">-->
<!--                            <div class="checkbox">-->
<!--                                <label>-->
<!--                                    --><?//= $form->checkBox($signUpModel,'agreeTerms'); ?>
<!--                                    <span>-->
<!--                                --><?//= Yii::t('app' ,'I agree with the <a data-toggle="modal" data-target="#terms-modal" href="#">Terms and Policies</a>')?>
<!--                            </span>-->
<!--                                </label>-->
<!--                                --><?// echo $form->error($signUpModel,'agreeTerms',array('class'=>'errorMessage tip'));?>
<!--                            </div>-->
<!--                        </div>-->
<!--                        --><?//= CHtml::submitButton(Yii::t('app','Sign Up'),array('class'=>"button-field btn")); ?>
<!--                    --><?php //$this->endWidget(); ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->