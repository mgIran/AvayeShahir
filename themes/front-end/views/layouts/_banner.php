<?php
/** @var $this Controller */
if($this->slides):
?>
<section class="introduction">
    <div class="slider" data-loop="true">
        <?php
        foreach($this->slides as $slide):
            ?>
            <div class="slider-item">
<!--                <h2 dir="auto">--><?//= Yii::t('app','Learn English with us ...'); ?><!--</h2>-->
                <h2 dir="auto"><?= CHtml::encode($slide->description); ?></h2>
                <div class="slider-thumbnail">
                    <div class="mask"></div>
                    <img src="<?= Yii::app()->baseUrl.'/uploads/slideshow/'.$slide->image ?>" alt="<?= $slide->image ?>" title="<?= $slide->image ?>">
                </div>
            </div>
            <?php
        endforeach;
        ?>
    </div>
    <div class="logo"></div>
    <div class="chevron">
        <a class="mover scroll-link" href="#courses">
            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 245.059 245.059" xml:space="preserve">
                <g>
                    <path d="M217.774,121.224l-95.252,84.224l-95.22-84.224c-6.229-6.229-16.368-6.229-22.597,0
                        s-6.229,16.368,0,22.566l106.312,94.044c3.178,3.21,7.342,4.704,11.505,4.64c4.164,0.095,8.327-1.398,11.505-4.545
                        l106.344-94.044c6.198-6.229,6.198-16.4,0-22.597C234.11,115.027,223.971,114.995,217.774,121.224z"></path>
                    <path d="M110.984,123.894c3.178,3.178,7.342,4.704,11.505,4.64c4.164,0.064,8.359-1.462,11.505-4.64
                        L240.307,29.85c6.325-6.229,6.325-16.336,0.064-22.597c-6.229-6.229-16.4-6.229-22.597,0l-95.252,84.224L27.301,7.252
                        c-6.261-6.229-16.4-6.229-22.629,0s-6.229,16.368,0,22.597L110.984,123.894z"></path>
                </g>
            </svg>
        </a>
    </div>
</section>
<?php
if(count($this->slides)>1)
    Yii::app()->clientScript->registerScript('slider', "
        if ($('.slider').length != 0) {
            var loop = $('.slider').attr('data-loop');
            if (typeof loop === 'undefined')
                loop = false;
            $('.slider').owlCarousel({
                items: 1,
                dots: false,
                nav: true,
                navText: [\"<i class='arrow-icon'></i>\", \"<i class='arrow-icon'></i>\"],
                autoplay: true,
                autoplayTimeout: 8000,
                autoplayHoverPause: false,
                rtl: true,
                autoHeight: true,
                loop: loop
            });
    
            $('.slider-overlay-nav').click(function () {
                if ($(this).hasClass('slider-next'))
                    $('.slider .owl-controls .owl-nav .owl-next').trigger('click');
                else if ($(this).hasClass('slider-prev'))
                    $('.slider .owl-controls .owl-nav .owl-prev').trigger('click');
                return false;
            });
        }
    ");
endif;