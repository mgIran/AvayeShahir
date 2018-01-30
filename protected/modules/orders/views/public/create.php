<?php
/* @var $this OrdersManageController */
/* @var $model Orders */
/* @var $filesArray array */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);
?>
<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><?= Yii::t('app', 'Article Translation; Editing TOEFL, IELTS, and GRE Writing Samoles; & Editing SOP and CV') ?></h2>
    </div>
</div>
<div class="page-content courses gray-bg">
    <div class="container">
        <?php $this->renderPartial('_form', array('model'=>$model, 'filesArray' => $filesArray)); ?>
    </div>
</div>