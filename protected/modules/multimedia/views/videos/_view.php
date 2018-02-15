<?php
/* @var $this MultimediaVideosController */
/* @var $data Multimedia */
?>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 video-item">
    <div class="inner-item">
        <a href="<?= $this->createUrl('/multimedia/videos/'.$data->id.'/'.urlencode($data->title)) ?>" title="<?= $data->title ?>">
            <div class="image-container">
                <img src="<?php echo Yii::app()->baseUrl.'/uploads/multimedia/thumbnail/'.$data->thumbnail;?>" alt="<?= $data->title ?>" title="<?= $data->title ?>">
            </div>
            <div class="text-container" style="margin-top: 15px;">
                <h5><?php echo $data->title;?></h5>
            </div>
        </a>
    </div>
</div>