<footer class="footer" >
    <div class="box center-block">
        <div class="contact-box" id="contact">
            <?= $this->renderPartial('//layouts/_loading'); ?>
            <h4 class="yekan-text"><?= Yii::t('app','Contact Us') ?></h4>
            <?php $this->renderPartial("//layouts/_flashMessage",array('prefix'=>'footer-'));?>
            <?php
            /* @var $form CActiveForm */
            $contactModel = new ContactForm();
            $form=$this->beginWidget('CActiveForm', array(
                'id'=>'footer-contact-form',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                    'afterValidate' => 'js:function(form ,data ,hasError){
                    console.log(hasError);
                        if(!hasError)
                        {
                            var form = $("#footer-contact-form");
                            var loading = $(".footer .loading-container");
                            var url = \''.Yii::app()->createUrl('/site/contact').'\';
                            submitAjaxForm(form ,url ,loading ,"if(html.state == \'ok\') location.reload();");
                        }
                        else
                            $(\'#yw0_button\').click();
                    }'
                ),
                'htmlOptions' => array(
                    'class' => 'form-group'
                )
            ));
            ?>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <?php echo $form->textField($contactModel,'name' ,array(
                        'placeholder' => Yii::t('app','Name'),
                        'class' => 'text-field'
                    ));
                    echo $form->error($contactModel,'name');?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                    <?php echo $form->textField($contactModel,'email' ,array(
                        'placeholder' => Yii::t('app','Email'),
                        'class' => 'text-field'
                    ));
                    echo $form->error($contactModel,'email');?>
                </div>
                <div>
                    <?php echo $form->textArea($contactModel,'body',array(
                        'placeholder' => Yii::t('app','Message Body'),
                        'class' => 'text-field'
                    ));
                    echo $form->error($contactModel,'body'); ?>
                </div>
                <div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <?php echo $form->textField($contactModel,'verifyCode',array(
                            'placeholder' => Yii::t('app','Verification Code'),
                            'class' => 'text-field'
                        )); ?>
                        <?php echo $form->error($contactModel,'verifyCode'); ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 captcha">
                        <?php
                        $this->widget('CCaptcha');
                        ?>
                    </div>
                </div>
            <?= CHtml::submitButton(Yii::t('app','Send'),array('class'=>"button-field btn pull-left")); ?>
            <?php
            echo CHtml::hiddenField('ajax','footer-contact-form', array('id' => false));
            $this->endWidget(); ?>
        </div>
        <div class="info-box">
            <div class="col-md-6">
                <div><i class="map-point"></i><div class="address <?= Yii::app()->language == 'fa' ?"text-right":"text-left" ?>"><?= Yii::t("app",'Unit 1, No 9, 10th Street, Sarafraz Street, Beheshti Avenue, Tehran, Iran.') ?></div></div>
                <div>
                    <i class="phone"></i>
                    <div class="address ltr <?= Yii::app()->language == 'fa' ?"text-right":"text-left" ?>"><?= Yii::app()->language == 'fa'?Controller::parseNumbers("021 88971896 - 021 88546127 - 021 88546128 - 021 88391538"):'021 88971896 - 021 88546127 - 021 88546128 - 021 88391538' ?></div>
                </div>
                <p>
                    <i class="email"></i>
                    <span>pardis@avayeshahir.com</span>
                </p>
                <p>
                    <span>Instagram ID: @avaye_shahir</span>
                </p>
            </div>
            <div class="col-md-6">
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
            <p class="copyright"><?= Yii::t('app','All Rights Reserved By Pardis-e Avaye Shahir. ©‏') ?>&nbsp;<?= Yii::app()->language=='fa'?Controller::parseNumbers('1394'):'2016'; ?> </p>
        </div>
    </div>
</footer>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-115410787-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-115410787-1');
</script>
