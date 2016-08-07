<?php
/* @var $data UserTransactions */
JalaliDate::date("Y/m/d - H:i",$data->date);
?>
<div class="tr">
    <div class="td col-lg-2 col-md-2 col-sm-2 col-xs-2"><?= $data->sale_reference_id ?></div>
    <div class="td col-lg-2 col-md-2 col-sm-2 col-xs-2"><?= (Yii::app()->language == 'fa' ? Controller::parseNumbers(number_format($data->amount)):number_format($data->amount)).' '.Yii::t('app','Toman')?></div>
    <div class="td col-lg-3 col-md-3 col-sm-3 hidden-xs"><?= Yii::app()->language == 'fa' ? Controller::parseNumbers(JalaliDate::date("Y/m/d - H:i",$data->date)):JalaliDate::date("Y/m/d - H:i",$data->date,false); ?></div>
    <div class="td col-lg-5 col-md-5 col-sm-5 col-xs-5"><?= $data->description ?></div>
</div>