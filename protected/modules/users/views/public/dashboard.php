<?php
/* @var $this PublicController */
/* @var $model Users */

if(isset($_GET['tab']) && !empty($_GET['tab']))
    $tab = $_GET['tab'];
?>
<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><?= $model->fullName ?></h2>
    </div>
</div>
<div class="page-content courses">

    <div class="container">
        <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12 col-lg-pull-2 col-md-pull-2 col-sm-pull-1 col-lg-push-2 col-md-push-2 col-sm-push-1">
            <ul class="nav nav-tabs">
                <li class="<?= isset($tab)?'':'active'; ?>">
                    <a data-toggle="tab" href="#general-tab"><?= Yii::t('app','User Details')?></a>
                </li>
                <li class="<?= isset($tab) && $tab == 'setting' ?'active':''; ?>">
                    <a data-toggle="tab" href="#setting-tab"><?= Yii::t('app','Change Password')?></a>
                </li>
            </ul>

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
            </div>
        </div>
    </div>
</div>