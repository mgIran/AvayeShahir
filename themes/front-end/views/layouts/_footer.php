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
            echo CHtml::hiddenField('ajax','footer-contact-form');
            $this->endWidget(); ?>
        </div>
        <div class="info-box">
            <div class="col-md-6">
                <p>
                    <i class="map-point"></i><span>
                        تهران: خیابان شهید بهشتی، خ سرفراز (قائم مقام فراهانی) کوچه دهم، پلاک 9، واحد 1
</span>
                </p>
                <p>
                    <i class="phone"></i>
                    <span class="phone-number">021 88730902 - 021 88502049</span>
                </p>
                <p>
                    <i class="email"></i>
                    <span>pardis@avayeshahir.com</span>
                </p>
            </div>
            <div class="col-md-6">
                <h4>ما را دنبال کنید</h4>
                <p>
                    <a href="#" class="social-media facebook"></a>
                    <a href="#" class="social-media twitter"></a>
                    <a href="#" class="social-media google-plus"></a>
                    <a href="" class="social-media telegram"></a>
                </p>
                <p class="copyright">همهٔ حقوق برای موسسه پردیس آوای شهیر محفوظ است. ©‏ <?= JalaliDate::date('Y',time()) ?> </p>
            </div>
        </div>
    </div>
</footer>