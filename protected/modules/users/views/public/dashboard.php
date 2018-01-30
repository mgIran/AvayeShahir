<?php
/* @var $this PublicController */
/* @var $model Users */
/* @var $transactions CActiveDataProvider */
/* @var $totalTransactionsAmount string */
if(isset($_GET['tab']) && !empty($_GET['tab']))
    $tab = $_GET['tab'];
?>
<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><?= Yii::t('app', 'Dashboard') ?></h2>
        <div class="details"><span><?= $model->userDetails->getFullName() ?></span></div>
    </div>
</div>
<div class="container-fluid relative">
    <div class="mobile-bar hidden-lg hidden-md hidden-sm">
        <a href="#" class="btn btn-info dashboard-menu-trigger"><?= Yii::t('app', 'Toggle Menu') ?></a>
    </div>
    <div class="side-bar">
        <div class="mobile-bar hidden-lg hidden-md hidden-sm">
            <a href="#" class="close-menu-btn dashboard-menu-trigger"><i class="icon arrow-icon"></i></a>
        </div>
        <div class="scroll-container">
            <h5><?= Yii::t('app','General') ?></h5>
            <ul>
                <li class="<?= isset($tab)?'':'active'; ?>">
                    <a data-toggle="tab" href="#general-tab">
                        <i class="icon dashboard-icon"></i>
                        <span><?= Yii::t('app','User Details')?></span>
                    </a>
                </li>
                <li class="<?= isset($tab) && $tab == 'transactions' ?'active':''; ?>">
                    <a data-toggle="tab" href="#transactions-tab">
                        <i class="icon transaction-icon"></i>
                        <span><?= Yii::t('app','Transactions And Registers')?></span>
                    </a>
                </li>
                <li class="<?= isset($tab) && $tab == 'orders' ?'active':''; ?>">
                    <a data-toggle="tab" href="#orders-tab">
                        <i class="icon cart-icon"></i>
                        <span><?= Yii::t('app','Orders')?></span>
                        <?php
                        $t = Orders::model()->count(['condition' => 'user_id = :user_id and status = :s', 'params' => [":user_id"=> Yii::app()->user->getId(),":s"=> Orders::ORDER_STATUS_PAYMENT]]);
                        if($t):
                        ?>
                        <span class="badge"><?= $t ?></span>
                        <?php
                        endif;
                        ?>
                    </a>
                </li>
                <li class="<?= isset($tab) && $tab == 'setting' ?'active':''; ?>">
                    <a data-toggle="tab" href="#setting-tab">
                        <i class="icon setting-icon"></i>
                        <span><?= Yii::t('app','Change Password')?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div id="general-tab" class="tab-pane fade <?= isset($tab)?'':'active in'; ?>">
            <?php $this->renderPartial('_general',array(
                'model'=>$model->userDetails,
            ))?>
        </div>
        <div id="setting-tab" class="tab-pane fade <?= isset($tab) && $tab == 'setting' ?'active in':''; ?>">
            <?php $this->renderPartial('_setting',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="orders-tab" class="tab-pane fade <?= isset($tab) && $tab == 'orders' ?'active in':''; ?>">
            <?php $this->renderPartial('_orders',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="transactions-tab" class="tab-pane fade <?= isset($tab) && $tab == 'transactions' ?'active in':''; ?>">
            <?php $this->renderPartial('_transactions',array(
                'model'=>$model,
                'dataProvider'=>$transactions,
            ))?>
        </div>
    </div>
</div>