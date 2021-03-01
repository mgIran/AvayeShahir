<?php
$latestVideo = Multimedia::getLatest('videos', 5, 'array');
if ($latestVideo):
    ?>
    <section class="signup video-bg">
        <div class="mask"></div>
        <div class="container-fluid">
            <h2 class="yekan-text text-center"><?= Yii::t('app', 'Latest Video') ?></h2>
            <div class="video-carousel">
                <?php foreach ($latestVideo as $video): ?>
                    <div class="home-video col-lg-6 col-md-6 col-md-8 col-xs-12 text-center">
                        <div class="data"><?php if ($video->type == Multimedia::TYPE_VIDEO): ?>
                                <?= $video->data ?>
                            <?php else: ?>
                                <video preload="metadata" controls style="width: 100%">
                                    <source src="<?php echo Yii::app()->baseUrl . '/uploads/multimedia/videos/' . $video->data; ?>"
                                            type="video/mp4">
                                </video>
                            <?php endif; ?></div>
                        <h4 class="yekan-text"><?= CHtml::encode($video->title) ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="clearfix"></div>
            <div class="text-center">
                <a href="<?= $this->createUrl('/multimedia/videos') ?>" class="flat-button"><?= Yii::t('app',
                        'More Videos') ?></a>
            </div>
        </div>
    </section>
    <?php
    Yii::app()->clientScript->registerScript("video-carousel", "
    $('.video-carousel').owlCarousel({
        " . (Yii::app()->language == 'fa' ? 'rtl:true,' : '') . "
        navText:['<span class=\"arrow\"></span>','<span class=\"arrow\"></span>'],
        navClass: ['owl-prev disabled','owl-next'],
        callbacks: true,
        info: true,
        margin:30,
        items:1,
        responsive : {
            0 : {
                nav : false,
                dots : true,
            },
            992 :{
                nav : true,
                dots : false,
            },
            1025 :{
                nav : true,
                dots : false,
            },
            1201 :{
                nav : true,
                dots : false,
            },
            1401 :{
                nav : true,
                dots : false,
            },
            1601 :{
                nav : true,
                dots : false,
            },
        },
        onTranslated: $(this).on('translated.owl.carousel', function(e) {
            var items_per_page = e.page.size;
            var nav_container = $('.video-carousel .owl-nav');
            var item_index = e.item.index;
            var item_count = e.item.count;
            var last_vis_item_index = items_per_page + item_index;
            if(last_vis_item_index === item_count){
                $(nav_container).find('div:last').addClass('disabled');
            }
            else{
                $(nav_container).find('div:last').removeClass('disabled');
            }
            if(item_index != 0){
                $(nav_container).find('div:first').removeClass('disabled');
            }
            else{
                $(nav_container).find('div:first').addClass('disabled');
            }
        }),
    });");
endif;