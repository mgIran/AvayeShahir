<?php
/* @var $this CreditController */
/* @var $class Classes */
?>

<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><?= Yii::t('app','Register in Class') ?></h2>
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
                   href="<?= Yii::app()->createAbsoluteUrl('//') ?>"><?= Yii::t('app', 'Back') ?></a>
            </div>
            <?php
        }else {
            ?>
            <h3><?= Yii::t('app', 'Payment Details') ?></h3>
            <div class="table payment">
                <div class="tr">
                    <div class="td"><?= Yii::t('app', 'Title') ?></div>
                    <div class="td"><?= $class->title ?></div>
                </div>
                <div class="tr">
                    <div class="td"><?= Yii::t('app', 'Course') ?>&nbsp;</div>
                    <div class="td">
                        <a href="<?= Yii::app()->createUrl('/courses/'.urlencode($class->course->title).'/'.$class->course->id); ?>">
                            <?php echo $class->course->title ?>
                        </a>
                    </div>
                </div>
                <div class="tr">
                    <div class="td"><?= Yii::t('app', 'Department') ?>&nbsp;</div>
                    <div class="td">
                        <a href="<?= Yii::app()->createUrl('/courses/'.urlencode($class->course->title).'/'.$class->course->id); ?>">
                            <?php echo $class->category->title ?>
                        </a>
                    </div>
                </div>

                <div class="tr">
                    <div class="td">
                        <?= Yii::t('app', 'Instructor') ?>&nbsp;
                    </div>
                    <div class="td">
                        <?= $class->teacher->getFullName() ?>
                    </div>
                </div>

                <div class="tr">
                    <div class="td"><?= Yii::t('app', 'Start & End of the Course') ?></div>
                    <div class="td">
                        <?= Yii::t('app', 'from') ?>&nbsp;
                        <span><?php echo Yii::app()->language == 'fa' ? Controller::parseNumbers(JalaliDate::date("Y/m/d", $class->startClassDate)) : date("Y/m/d", $class->startClassDate) ?></span>&nbsp;
                        <?= Yii::t('app', 'to') ?>&nbsp;
                        <span><?php echo Yii::app()->language == 'fa' ? Controller::parseNumbers(JalaliDate::date("Y/m/d", $class->endClassDate)) : date("Y/m/d", $class->endClassDate) ?></span>
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <?= Yii::t('app', 'Class Days') ?>&nbsp;
                    </div>
                    <div class="td">
                        <?
                        $days = explode(',', $class->classDays);
                        foreach($days as $key => $day) {
                            $days[$key] = JalaliDate::getDayName($day, Yii::app()->language);
                        }
                        if(Yii::app()->language == 'fa')
                            echo implode(' ، ', $days);
                        else
                            echo implode(' , ', $days);
                        ?>
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <?= Yii::t('app', 'Class Hours') ?>&nbsp;
                    </div>
                    <div class="td">
                        <?
                        echo (Yii::app()->language == 'fa' ? ' از '.Controller::parseNumbers($class->startClassTime) : ' from '.$class->startClassTime).
                            (Yii::app()->language == 'fa' ? ' تا '.Controller::parseNumbers($class->endClassTime) : ' to '.$class->endClassTime);
                        ?>
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <?= Yii::t('app', 'Sessions') ?>&nbsp;
                    </div>
                    <div class="td">
                        <?= Yii::app()->language == 'fa' ? Controller::parseNumbers($class->sessions).'&nbsp;&nbsp;جلسه' : $class->sessions ?>
                    </div>
                </div>
                <div class="tr">
                    <div class="td">
                        <?= Yii::t('app', 'Tuition Fee') ?>&nbsp;
                    </div>
                    <div class="td">
                        <?
                        echo $class->getHtmlPrice();
                        ?>
                    </div>
                </div>
            </div>
            <?php echo CHtml::beginForm(Yii::app()->createUrl('/courses/register/bill/'.$class->id)); ?>
            <?php echo CHtml::hiddenField('pay', ''); ?>
            <div class="buttons">
                <?php echo CHtml::submitButton($class->price!=0?Yii::t('app', 'Payment'):Yii::t('app', 'Register'), array('class' => 'btn btn-success btn-lg pull-left')); ?>
            </div>

            <?php echo CHtml::endForm(); ?>
            <?php
        }
        ?>
    </div>
</div>