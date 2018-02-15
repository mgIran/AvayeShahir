<?php
/* @var $this OrdersPublicController */
/* @var $model Orders */
?>

<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><?= Yii::t('app','Order Payment') ?></h2>
    </div>
</div>
<div class="page-content courses">
    <div class="container">
        <?php
        if($message) {
            ?>
            <h3><?= $message ?></h3>
            <div class="form-group">
                <a class="btn btn-info"
                   href="<?= Yii::app()->createUrl('/dashboard?tab=orders') ?>"><?= Yii::t('app', 'Back') ?></a>
            </div>
            <?php
        }else {
            ?>
            <h3><?= Yii::t('app', 'Payment Details') ?></h3>
            <div class="table payment">
                <div class="tr">
                    <div class="td"><?= Yii::t('app', 'Title') ?></div>
                    <div class="td"><?= $model->title ?></div>
                </div>
                <div class="tr">
                    <div class="td"><?= Yii::t('app', 'Category') ?></div>
                    <div class="td"><?= $model->category->title ?></div>
                </div>
                <div class="tr">
                    <div class="td"><?= Yii::t('app', 'Order Priority') ?></div>
                    <div class="td"><?= $model->getOrderPriorityLabel(true) ?></div>
                </div>
                <div class="tr">
                    <div class="td"><?= Yii::t('app', 'Done Time') ?></div>
                    <div class="td"><?= $model->getDoneTime() ?></div>
                </div>
                <div class="tr">
                    <div class="td"><?= Yii::t('app', 'Create Date') ?></div>
                    <div class="td"><?= Yii::app()->language == 'fa' ? Controller::parseNumbers(JalaliDate::date("Y/m/d - H:i",$model->create_date)):date("Y/m/d - H:i",$model->create_date) ?></div>
                </div>
                <div class="tr">
                    <div class="td"><?= Yii::t('app', 'Update Date') ?></div>
                    <div class="td"><?= Yii::app()->language == 'fa' ? Controller::parseNumbers(JalaliDate::date("Y/m/d - H:i",$model->update_date)):date("Y/m/d - H:i",$model->update_date) ?></div>
                </div>
                <div class="tr">
                    <div class="td"><?= Yii::t('app', 'Payment Amount') ?></div>
                    <div class="td"><?= $model->getOrderPrice() ?></div>
                </div>
            </div>
            <?php echo CHtml::beginForm(Yii::app()->createUrl('/edit&translation/bill/'.$model->id)); ?>
            <?php echo CHtml::hiddenField('pay', ''); ?>
            <div class="form-group">
                <div class="text-center col-lg-8 col-md-8 col-sm-8 col-xs-12 <?= Yii::app()->language == 'fa'?'col-lg-push-2 col-md-push-2 col-sm-push-2':'col-lg-pull-2 col-md-pull-2 col-sm-pull-2' ?>">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <h4>درگاه موردنظر خود را انتخاب کنید</h4>
                    </div>
                    <div class="text-center relative gateway-select">
                        <div class="gateway-logo">
                            <img src="<?= Yii::app()->baseUrl.'/images/fanavaLogo.png' ?>" width="200" height="200" alt="فن آوا کارت" title="فن آوا کارت">
                        </div>
                        <?php echo CHtml::radioButton('gateway', true, array('value'=>UserTransactions::GATEWAY_SINA)) ?>
                        <?php echo CHtml::label('بانک سینا','',array('style' => 'color:#000')) ?>
                    </div>
                    <div class="text-center relative gateway-select">
                        <div class="gateway-logo">
                            <img src="<?= Yii::app()->baseUrl.'/images/mellatLogo.png' ?>" width="200" height="200" alt="بانک ملت" title="بانک ملت">
                        </div>
                        <?php echo CHtml::radioButton('gateway', false, array('value'=>UserTransactions::GATEWAY_MELLAT)) ?>
                        <?php echo CHtml::label('بانک ملت','',array('style' => 'color:#000')) ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Payment'), array('class' => 'btn btn-success btn-lg pull-left')); ?>
            </div>

            <?php echo CHtml::endForm(); ?>
            <?php
        }
        ?>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScript('changePayment',"
    $('.gateway-select input[type=\"radio\"]:checked').parent().addClass('select');
    $(\"body\").on('click', '.gateway-select input[type=\"radio\"]', function () {
        $('.gateway-select').not($(this)).removeClass('select');
        $(this).parent().addClass('select');
    })
", CClientScript::POS_READY);