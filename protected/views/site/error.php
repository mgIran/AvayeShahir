<?php
/* @var $this SiteController */
/* @var $error array */

?>
<div class="page-error">
    <div class="code"><?php echo $code; ?></div>
    <div class="title"><?php echo CHtml::encode($message);?>
    <?php if(isset($_GET['debug'])):?><br><code style="color:red">File:<?= $file;?><br>Line: <?= $line?></code><?php endif;?></div>

    <div class="buttons">
        <div class="row">
            <div class="col-md-6">
                <a href="<?php echo Yii::app()->getBaseUrl(true);?>" class="btn btn-danger btn-block"><?= Yii::t('app','Home') ?> <i class="arrow-icon right"></i></a>
            </div>
            <div class="col-md-6">
                <button onclick="history.back();" class="btn btn-info btn-block"><i class="arrow-icon left"></i> <?= Yii::t('app','Back') ?></button>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="copyright">
        <div class="ltr">
            <?php $this->renderPartial('//layouts/_copyright');?>
        </div>
        <div>
            <a href="<?php echo $this->createUrl('/#about')?>"><?= Yii::t('app','About') ?></a> / <a href="<?php echo $this->createUrl('/#contact')?>"><?= Yii::t('app','Contact Us') ?></a>
        </div>
    </div>
    <!-- ./Copyright -->

</div>
