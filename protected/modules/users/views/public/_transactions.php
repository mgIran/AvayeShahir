<?php
/* @var $this PublicController */
/* @var $model Users */
/* @var $dataProvider CActiveDataProvider */
/* @var $form CActiveForm */
?>
<div class="table table-responsive">
    <div class="thead">
        <div class="tr">
            <div class="th col-lg-2 col-md-2 col-sm-2 col-xs-2"><?= Yii::t('app','Tracking Code')?></div>
            <div class="th col-lg-2 col-md-2 col-sm-2 col-xs-2"><?= Yii::t('app','Amount')?></div>
            <div class="th col-lg-3 col-md-3 col-sm-3 hidden-xs"><?= Yii::t('app','Date')?></div>
            <div class="th col-lg-5 col-md-5 col-sm-5 col-xs-5"><?= Yii::t('app','Description')?></div>
        </div>
    </div>
    <div class="tbody">
        <?
        $this->widget("zii.widgets.CListView",array(
            'id' => 'transactions-list-view',
            'dataProvider' => $dataProvider,
            'itemView' => '_transaction_view',
            'template' => '{items} {pager}'
        ));
        ?>
    </div>
</div>
