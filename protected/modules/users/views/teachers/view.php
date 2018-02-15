<?
/* @var $model Users */
$fileUrl = Yii::app()->baseUrl.'/uploads/teachers/files/';
$fileDir = Yii::getPathOfAlias("webroot").'/uploads/teachers/files/';
?>
<div class="page-title-container courses personnel-page-header">
    <div class="mask"></div>
    <div class="container">
        <h2><?= $model->teacherDetails->getFullName() ?></h2>
        <div class="details">
            <span><?= Yii::t('app','Grade') ?></span>
            <span><?= $model->teacherDetails->grade ?></span>
        </div>
    </div>
</div>
<div class="page-content courses personnel-page">
    <div class="container">
        <div class="basic-information">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="image">
                    <?
                    if($model->teacherDetails->avatar && file_exists(Yii::getPathOfAlias('webroot').'/uploads/teachers/'.$model->teacherDetails->avatar)):
                        ?>
                        <img src="<?= Yii::app()->baseUrl.'/uploads/teachers/'.$model->teacherDetails->avatar ?>" alt="<?= $model->teacherDetails->getFullName() ?>" title="<?= $model->teacherDetails->getFullName() ?>">
                        <?
                    endif;
                    ?>
                </div>
                <div class="files">
                <?
                if($model->teacherDetails->file && file_exists($fileDir.$model->teacherDetails->file)):
                    ?>
                    <h3><?= Yii::t('app','Resume File') ?></h3>
                    <div class="file">
                        <a href="<?= $fileUrl.$model->teacherDetails->file ?>"></a>
                            <span><?= Yii::t('app','Download') ?></span>
                            <span class="extension"><?= strtoupper( pathinfo($model->teacherDetails->file, PATHINFO_EXTENSION)) ?></span>
                            <span class="download">
                                <i></i>
                            </span>
                    </div>
                    <?
                endif;
                ?>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <h3><?= Yii::t('app' ,'Resume') ?></h3>
                <?= $model->teacherDetails->resume; ?>
            </div>
        </div>
    </div>
</div>