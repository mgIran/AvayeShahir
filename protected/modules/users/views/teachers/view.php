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
        <div class="basic-information col-lg-10 col-md-10 col-sm-12 col-xs-12 col-lg-push-1-1">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="image">
                    <?
                    if($model->teacherDetails->avatar && is_file(Yii::getPathOfAlias('webroot').'/uploads/teachers/'.$model->teacherDetails->avatar)):
                        ?>
                        <img src="<?= Yii::app()->baseUrl.'/uploads/teachers/'.$model->teacherDetails->avatar ?>" alt="<?= $model->teacherDetails->getFullName() ?>" title="<?= $model->teacherDetails->getFullName() ?>">
                        <?
                    endif;
                    ?>
                </div>
                <div class="files">
                <?
                if($model->teacherDetails->file && is_file($fileDir.$model->teacherDetails->file)):
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
                    <h5><b><?= Yii::t('app','Social Network Links') ?></b></h5>
                    <div>
                        <?php
                        $socials = $model->teacherDetails->social_links?json_decode($model->teacherDetails->social_links):null;
                        if($socials):?>
                            <ul>
                                <?php foreach ($socials as $key => $social):
                                    if($key == 0)
                                        $title = Yii::t('app', 'Facebook');
                                    else if($key == 1)
                                        $title = Yii::t('app', 'Twitter');
                                    else
                                        $title = $social->title;
                                    ?>
                                    <li><a href="<?= $social->value ?>"><?= $title ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
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