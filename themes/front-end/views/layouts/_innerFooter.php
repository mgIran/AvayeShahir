<footer class="footer">
    <div class="container">
        <div class="info-box">
            <div class="col-md-6">
                <div><i class="map-point"></i><div class="address <?= Yii::app()->language == 'fa' ?"text-right":"text-left" ?>"><?= Yii::t("app",'Unit 1, No 9, 10th Street, Sarafraz Street, Beheshti Avenue, Tehran, Iran.') ?></div></div>
                <p>
                    <i class="phone"></i>
                    <div class="address ltr <?= Yii::app()->language == 'fa' ?"text-right":"text-left" ?>"><?= Yii::app()->language == 'fa'?Controller::parseNumbers("021 88971896 - 021 88546127 - 021 88546128"):'021 88971896 - 021 88546127 - 021 88546128' ?></div>
                </p>
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
<!--            <div class="col-md-4">-->
<!--                --><?//= $this->renderPartial('//layouts/_map'); ?>
<!--            </div>-->
            <p class="copyright"><?= Yii::t('app','All Rights Reserved By Pardis-e Avaye Shahir. ©‏') ?>&nbsp;<?= Yii::app()->language=='fa'?Controller::parseNumbers('1394'):'2016'; ?> </p>
        </div>
    </div>
</footer>

<!--magnifier modal-->
<div class="magnifier-modal modal fade" id="magnifier-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="picture-view"></div>
                <div class="details-view"></div>
            </div>
        </div>
    </div>
</div>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-115410787-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-115410787-1');
</script>
