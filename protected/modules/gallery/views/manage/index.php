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
                Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/ekko-lightbox.css');
                Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/ekko-lightbox.min.js',CClientScript::POS_END);
                Yii::app()->clientScript->registerScript("lightbox-script","
                    $('body').on('click', '[data-toggle=\"lightbox\"]', function(event) {
                        event.preventDefault();
                        $(this).ekkoLightbox();
                    });
                ",CClientScript::POS_LOAD);

                Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/isotope.pkgd.min.js',CClientScript::POS_END);
                Yii::app()->clientScript->registerScript("owl-carousel-script","
                    $('.gallery-carousel').isotope({
                        itemSelector : '.gallery-item',
                        layoutMode: 'masonry',
                        masonry: {
                          gutter: 5
                        }
                    });
                ",CClientScript::POS_READY);
                foreach($models as $model):
                    ?>
                    <div class="gallery-item">
                        <a href="<?= Yii::app()->baseUrl.'/uploads/gallery/'.$model->file_name; ?>"
                           data-toggle="lightbox" data-gallery="gallery"
                        >
                            <div class="gallery-pic">
                                <img src="<?= Yii::app()->baseUrl.'/uploads/gallery/'.$model->file_name; ?>" alt="<?= $model->title ?>" title="<?= $model->title ?>" style="width: 100%">
                            </div>
                            <div class="gallery-detail container-fluid">
                                <div class="blur-mask" id="blur-mask-<?= $model->id ?>"></div>
                                <div class="gallery-detail-inner">
                                    <h2><?= $model->title ?></h2>
                                </div>
                            </div>
                        </a>
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
<style>
    .page-content.courses{
        margin: 0 !important;
        padding: 60px 0 !important;
        background-color: #f5f5f5;
    }
</style>