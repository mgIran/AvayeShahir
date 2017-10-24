<?php
/* @var $this PublicController */
/* @var $model Users */
/* @var $dataProvider CActiveDataProvider */
/* @var $form CActiveForm */
?>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <td><?= Yii::t('app','Tracking Code')?></td>
            <td><?= Yii::t('app','Amount')?></td>
            <td><?= Yii::t('app','Date')?></td>
            <td><?= Yii::t('app','Description')?></td>
        </tr>
        </thead>
        <tbody>
        <?
        if($dataProvider->totalItemCount):
            foreach($dataProvider->getData() as $data):
                ?>
                <tr>
                    <td><?= $data->sale_reference_id ?></td>
                    <td><?= $data->getHtmlAmount() ?></td>
                    <td><?= Yii::app()->language == 'fa' ? Controller::parseNumbers(JalaliDate::date("Y/m/d - H:i",$data->date)):date("Y/m/d - H:i",$data->date); ?></td>
                    <td><?= $data->description ?></td>
                </tr>
            <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="4" align="center"><?= Yii::t('app', 'No results found.') ?></td>
            </tr>
        <?php
        endif;
        ?>
        </tbody>
    </table>
</div>