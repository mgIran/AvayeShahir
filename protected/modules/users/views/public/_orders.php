<?php
/* @var $this UsersPublicController */
/* @var $model Users */
/* @var $dataProvider CActiveDataProvider */
/* @var $form CActiveForm */
?>
<div class="form-group">
    <a href="<?= $this->createUrl('/order') ?>" class="btn btn-info">
        <i class="icon icon-plus"></i>
        <?= Yii::t('app', 'New Order') ?>
    </a>
</div>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <td width="20px">#</td>
            <td><?= Yii::t('app','Title')?></td>
            <td><?= Yii::t('app','Status')?></td>
            <td><?= Yii::t('app','Create Date')?></td>
            <td><?= Yii::t('app','Cost')?></td>
            <td><?= Yii::t('app','Done Time')?></td>
            <td width="50px"></td>
        </tr>
        </thead>
        <tbody>
        <?
        if($model->orders):
            foreach($model->orders as $data):
                ?>
                <tr>
                    <td><?= $data->id ?></td>
                    <td><?= $data->title ?></td>
                    <td class="text-<?php
                        if($data->status == Orders::ORDER_STATUS_DELETED)
                            echo 'danger';
                        else if($data->status == Orders::ORDER_STATUS_PENDING)
                            echo 'info';
                        else if($data->status == Orders::ORDER_STATUS_PAYMENT)
                            echo 'warning';
                        else if($data->status == Orders::ORDER_STATUS_PAID)
                            echo 'success';
                        else if($data->status == Orders::ORDER_STATUS_DOING)
                            echo 'info';
                        else if($data->status == Orders::ORDER_STATUS_DONE)
                            echo 'primary';
                    ?>"><b><?= $data->getStatusLabel(true) ?></b></td>
                    <td><?= Yii::app()->language == 'fa' ? Controller::parseNumbers(JalaliDate::date("Y/m/d - H:i",$data->create_date)):date("Y/m/d - H:i",$data->create_date); ?></td>
                    <td><?= $data->getOrderPrice() ?></td>
                    <td><?= $data->getDoneTime() ?></td>
                    <td><a href="#" data-toggle="modal" data-target="#show-order-details"
                           data-href="<?= $this->createUrl('/orders/public/view/'.$data->id)?>"
                           class="btn btn-warning btn-xs modal-show-trigger no-margin"><?= Yii::t('app', 'Order Details') ?></a></td>
                </tr>
            <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="7" align="center"><?= Yii::t('app', 'No results found.') ?></td>
            </tr>
        <?php
        endif;
        ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="show-order-details">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?= Yii::t('app', 'Order Details') ?>
                    <button type="button" data-dismiss="modal" class="close">&times;</button>
                </h3>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('//layouts/_loading'); ?>
                <div class="order-content"></div>
            </div>
        </div>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript('show-order','
    var modalUrl;
    $("body").on("click", ".modal-show-trigger", function(e){
        e.preventDefault();
        modalUrl = $(this).data("href");
    });
    
    $("#show-order-details").on(\'show.bs.modal\', function () {
        $("#show-order-details .loading-container").show();
        $.ajax({
            url: modalUrl,
            dataType: "html",
            success: function(data){
                $("#show-order-details .order-content").html(data);
                $("#show-order-details .loading-container").hide();
            }
        });
    });
');