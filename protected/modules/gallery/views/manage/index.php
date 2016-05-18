<?
/* @var $models Gallery[] */
/* @var $title string */
?>
<div class="page-title-container gallery courses">
    <div class="mask"></div>
    <div class="container">
        <h2><?= $title ?></h2>
    </div>
</div>
<div class="page-content courses">
    <div class="container">
        <div class="gallery-carousel">
            <?
            if($models) :
                Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/owl.carousel.min.js');
                Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/animate.min.css');
                Yii::app()->clientScript->registerScript("owl-carousel-script","
                $('.gallery-carousel').owlCarousel({
                    ".(Yii::app()->language == 'fa'?'rtl:true,':'')."
                    navText:['<span class=\"arrow\"></span>','<span class=\"arrow\"></span>'],
                    nav:true,
                    autoHeight : true,
                    animateIn: 'fadeIn',
                    animateOut: 'fadeOut',
                    items:1,
                    margin:50,
                    stagePadding:50,
                });");
                foreach($models as $model):
                    ?>
                    <div class="gallery-item">
                        <div class="gallery-pic" data-toggle="tooltip" data-placement="top" title="<?= $model->title ?>">
                            <img src="<?= Yii::app()->baseUrl.'/uploads/gallery/'.$model->file_name; ?>" alt="<?= $model->title ?>">
                        </div>
                        <div class="gallery-detail container-fluid">
                            <div class="blur-mask" id="blur-mask-<?= $model->id ?>"></div>
                            <div class="gallery-detail-inner">
                                <h2><?= $model->title ?></h2>
                                <p class="text">
                                    <?= strip_tags($model->desc) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?
                    Yii::app()->clientScript->registerCss('blur-mask-'.$model->id,'
                        #blur-mask-'.$model->id.'{
                            background-image : url("'.Yii::app()->baseUrl.'/uploads/gallery/'.$model->file_name.'");
                        }
                    ');
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>