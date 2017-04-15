<?php
/* @var $model UserTransactions */
/* @var $msg string */
?>

<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><?= Yii::t('app','Transaction Details') ?></h2>
    </div>
</div>
<div class="page-content courses">
    <div class="container">
        <h3><?= Yii::t('app', 'Payment Details') ?></h3>
        <div class="table payment">
            <div class="tr">
                <div class="td"><?= Yii::t('app', 'Order Id') ?>&nbsp;</div>
                <div class="td"><?= $model->order_id ?></div>
            </div>
            <div class="tr">
                <div class="td"><?= Yii::t('app', 'Gateway') ?>&nbsp;</div>
                <div class="td"><?= $model->getGatewayLabel() ?></div>
            </div>
            <div class="tr">
                <div class="td"><?= Yii::t('app', 'Transaction Status') ?></div>
                <div class="td"><?= $model->res_code == 0?'موفق':'نا موفق' ?></div>
            </div>
            <?
            if($model->res_code > 0):
            ?>
            <div class="tr">
                <div class="td"><?= Yii::t('app', 'Bank Gateway Message') ?></div>
                <div class="td"><?= Yii::t('rezvan', $model->res_code)?></div>
            </div>
            <?
            elseif($model->res_code < 0):
                ?>
                <div class="tr">
                    <div class="td"><?= Yii::t('app', 'Bank Gateway Message') ?></div>
                    <div class="td"><?= $msg ?></div>
                </div>
                <?
            endif;
            ?>
            <div class="tr">
                <div class="td"><?= Yii::t('app', 'Tracking Code') ?>&nbsp;</div>
                <div class="td"><?= $model->sale_reference_id?$model->sale_reference_id:$model->ref_id ?></div>
            </div>
        </div>
    </div>
</div>