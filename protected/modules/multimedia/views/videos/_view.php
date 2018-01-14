<?php
/* @var $this MultimediaVideosController */
/* @var $data Multimedia */
?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 item">
    <div class="image-container">
        <img src="<?php echo Yii::app()->baseUrl.'/uploads/multimedia/thumbnail/'.$data->thumbnail;?>">
    </div>
    <div class="text-container" style="margin-top: 15px;">
        <a href="#" class="pull-left video-modal-trigger">مشاهده</a>
        <h5><?php echo $data->title;?></h5>
        <input type="hidden" id="video-script" value="<?php echo CHtml::encode($data->data);?>">
        <input type="hidden" id="video-title" value="<?php echo $data->title;?>">
    </div>
</div>