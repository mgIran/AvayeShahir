<?php
/* @var $classes Classes[] */
?>
<div class="container">
    <h3 class="yekan-text"><?= Yii::t('app' ,'Offered Classes') ?></h3>
    <?php
    if($classes) :
        ?>
        <ul class="nav col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
            foreach($classes as $course_id => $array):
                ?>
                <li><a data-target='#classes-tab-<?= $course_id ?>' data-toggle="tab" ><?= $array['title'] ?></a></li>
                <?php
            endforeach;
            ?>
        </ul>
        <div class="tab-content col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?
            foreach($classes as $course_id => $array):
                ?>
                <div id="classes-tab-<?= $course_id ?>" class="tab-pane fade">
                    <!--                <h3>--><?//= $array['title'] ?><!--</h3>-->
                    <div class="classes-carousel">
                        <?
                        foreach($array['objects'] as $class):
                            /** @var $class Classes */
                            $capPer = $class->capacity - $class->remainingCapacity == 0?0:(float)($class->capacity - $class->remainingCapacity)/$class->capacity*100;
                            ?>
                            <div class="class col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="inner">
                                    <div class="top-box">
                                        <div class="center-block">
                        <span class="circle-capacity bg-<?php
                        if($capPer >= 0 && $capPer< 10) echo 'success';
                        else if($capPer >= 10 && $capPer <= 80) echo 'warning';
                        else echo 'danger';
                        ?>" data-toggle="tooltip" title="<?= Yii::t('app','Capacity State')?>"></span>
                                            <!--                                --><?//
                                            //                                if($capPer >= 0 && $capPer< 10) $state = Yii::t('app', '');
                                            //                                else if($capPer >= 10 && $capPer <= 80) $state = '';
                                            //                                else echo $state = '';
                                            //                                ?>
                                        </div>
                                        <a href="#">
                                            <h4 data-toggle="tooltip" data-placement="top" title="<?= $class->title ?>"><?= $class->title ?></h4>
                                        </a>
                                        <? /*
                        <section class="progress" data-toggle="tooltip" title="<?= Yii::t('app','Class Capacity')?>">
                            <div class="progress-bar progress-bar-<?php
                            if($class->capacity - $class->remainingCapacity <= 3) echo 'success';
                            else if($class->capacity - $class->remainingCapacity <12) echo 'warning';
                            else echo 'danger';
                            ?>" role="progressbar"
                                 aria-valuenow="<?= $class->capacity - $class->remainingCapacity ?>" aria-valuemin="0" aria-valuemax="<?= $class->capacity ?>" style="width: <?= $capPer ?>%">
<!--                                    --><?//= Yii::app()->language == 'fa' ? '%'.Controller::parseNumbers($capPer):$capPer.'%' ?>
<!--                                    --><?php
//
//                                    if($class->remainingCapacity == 0):
////                                        echo (Yii::app()->language == 'fa'?
////                                            Controller::parseNumbers($class->capacity-$class->remainingCapacity):
////                                            $class->capacity-$class->remainingCapacity).' '.Yii::t('app','People');
////                                    else:
//                                        echo Yii::t('app','Completed');
//                                    endif;
//                                    ?>
                            </div>
                        </section>
                    */ ?>
                                        <!--                    <div class="text-danger remain-capacity">--><?//= Yii::t('app','Remaining Capacity').': '.$class->remainingCapacity ?><!--</div>-->
                                    </div>
                                    <div class="class-detail container-fluid">
                                        <div class="full line-2">
                                            <span><?= Yii::t('app','Course') ?>:&nbsp;</span>
                                            <a href="<?= Yii::app()->createUrl('/courses/'.urlencode($class->course->getValueLang('title', 'en')).'/'.$class->course->id); ?>">
                                                <?php echo $class->course->title ?>
                                            </a>
                                        </div>
                                        <div class="full line-2">
                                            <span><?= Yii::t('app','Department') ?>:&nbsp;</span>
                                            <a href="<?= Yii::app()->createUrl('/courses/'.urlencode($class->course->getValueLang('title', 'en')).'/'.$class->course->id.'/#collapse-category-'.$class->category->id); ?>">
                                                <?php echo $class->category->title ?>
                                            </a>
                                        </div>

                                        <div class="full">
                            <span>
                                <?= Yii::t('app','Instructor') ?>:&nbsp;
                            </span>
                            <span>
                                <?= $class->getTeachersFullName() ?>
                            </span>
                                        </div>
                                        <div class="full line-2">
                                            <span><?= Yii::t('app','Registration') ?>:</span><br><?= Yii::t('app','from') ?>&nbsp;<span><?php echo Yii::app()->language=='fa'?Controller::parseNumbers(JalaliDate::date("Y/m/d",$class->startSignupDate)):date("Y/m/d",$class->startSignupDate); ?></span>&nbsp;<?= Yii::t('app','up to') ?>&nbsp;<span><?php echo Yii::app()->language=='fa'?Controller::parseNumbers(JalaliDate::date("Y/m/d",$class->endSignupDate)):date("Y/m/d",$class->endSignupDate) ?></span>
                                        </div>
                                        <div class="full line-2">
                                            <span><?= Yii::t('app','Start & End of the Course') ?>:</span><br><?= Yii::t('app','from') ?>&nbsp;<span><?php echo Yii::app()->language=='fa'?Controller::parseNumbers(JalaliDate::date("Y/m/d",$class->startClassDate)):date("Y/m/d",$class->startClassDate) ?></span><span>&nbsp;<?= Yii::t('app','to') ?>&nbsp;</span><span><?php echo Yii::app()->language=='fa'?Controller::parseNumbers(JalaliDate::date("Y/m/d",$class->endClassDate)):date("Y/m/d",$class->endClassDate) ?></span>
                                        </div>
                                        <div class="full line-2">
                            <span>
                            <?= Yii::t('app','Class Days') ?>:&nbsp;
                            </span>
                            <span>
                                <?
                                $days = explode(',',$class->classDays);
                                foreach($days as $key => $day)
                                {
                                    $days[$key] = JalaliDate::getDayName($day ,Yii::app()->language);
                                }
                                if(Yii::app()->language == 'fa')
                                    echo implode(' ، ',$days);
                                else
                                    echo implode(' , ',$days);
                                ?>
                            </span>
                                        </div>
                                        <div class="full">
                            <span>
                                <?= Yii::t('app','Class Hours') ?>:&nbsp;
                            </span>
                            <span>
                                <?
                                echo (Yii::app()->language=='fa'?' از '.Controller::parseNumbers($class->startClassTime):' from '.$class->startClassTime).
                                    (Yii::app()->language=='fa'?' تا '.Controller::parseNumbers($class->endClassTime):' to '.$class->endClassTime);
                                ?>
                            </span>
                                        </div>
                                        <div class="full">
                            <span>
                                <?= Yii::t('app','Sessions') ?>:&nbsp;
                            </span>
                            <span>
                                <?= Yii::app()->language=='fa'?Controller::parseNumbers($class->sessions).'&nbsp;&nbsp;جلسه':$class->sessions ?>
                            </span>
                                        </div>
                                        <div class="full text-lg">
                            <span>
                                <?= Yii::t('app','Tuition') ?>:&nbsp;
                            </span>
                            <span>
                                <?
                                echo $class->htmlPrice;
                                ?>
                            </span>
                                        </div>
                                        <div class="text-center">
                                            <a href="<?= Yii::app()->createUrl('/courses/register/'.$class->id) ?>"
                                               class="btn btn-info"><?= Yii::t('app','Register')?>
                                            </a>
                                            <?php if($class->summary && !empty($class->summary)): ?>
                                                <a href="#" class="btn btn-success show-class-details"><?= Yii::t('app','Description')?></a>
                                                <div class="hidden class-details"><?
                                                    $purifier = new CHtmlPurifier();
                                                    $purifier->setOptions(array(
                                                        'HTML.Allowed'=> 'p,a[href|target],b,i,br',
                                                        'HTML.AllowedAttributes'=> 'style,id,class,src,dir',
                                                    ));
                                                    echo $text = $purifier->purify($class->summary);
                                                    ?>
                                                    <div class="clearfix"></div>
                                                    <a href="<?= Yii::app()->createUrl('/courses/register/'.$class->id) ?>"
                                                       class="btn btn-success"><?= Yii::t('app','Register')?>
                                                    </a>
                                                </div>
                                                <?php
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?
                        endforeach;
                        ?>
                    </div>
                </div>
                <?
            endforeach;
            ?>
            <div id="show-class-detail-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom: 1px solid #eee;">
                            <h4 style="margin-top: 0" class="pull-right"><?= Yii::t('app','Class Description') ?></h4>
                            <button type="button" class="close pull-left" style="color: #000 !important;font-size: 20px" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                        </div>
                    </div>

                </div>
            </div>
            <?php
            Yii::app()->clientScript->registerScript('show-class-details','
        $("body").on("click", ".show-class-details", function(e){
            e.preventDefault();
            var $this = $(this),
                $text = $this.parent().find(".class-details").html();
            if($text){
                $("#show-class-detail-modal .modal-body").html($text);
                $("#show-class-detail-modal").modal("show");
            }
        });
    ');
            Yii::app()->clientScript->registerScript("owl-carousel-class-script","
            var options = {
                    ".(Yii::app()->language == 'fa'?'rtl:true,':'')."
                    navText:['<span class=\"arrow\"></span>','<span class=\"arrow\"></span>'],
                    navClass: ['owl-prev disabled','owl-next'],
                    callbacks: true,
                    info: true,
                    margin:30,
                    responsive : {
                        0 : {
                            items:1,
                            nav : false,
                            margin :15,
                            dots : true,
                            stagePadding : 0
                        },
                        459 :{
                            items:1,
                            nav : true,
                            margin :50,
                            dots : true,
                            stagePadding : 50
                        },
                        768 :{
                            items:1,
                            nav : true,
                            margin :50,
                            dots : false,
                            stagePadding : 50
                        },
                        992 :{
                            items:1,
                            nav : true,
                            margin :50,
                            dots : false,
                            stagePadding : 50
                        },
                        1024 :{
                            items:1,
                            nav : true,
                            margin :15,
                            dots : false,
                            stagePadding : 15
                        },
                        1200 :{
                            items:2,
                            nav : true,
                            margin :10,
                            dots : false,
                            stagePadding : 0
                        },
                        1400 :{
                            items:2,
                            nav : true,
                            margin :0,
                            dots : false,
                            stagePadding : 0
                        },
                        1920 :{
                            items:3,
                            nav : true,
                            margin :0,
                            dots : false,
                            stagePadding : 0
                        },
                    },
                    onTranslated: $(this).on('translated.owl.carousel', function(e) {
                        var items_per_page = e.page.size;
                        var nav_container = $('.classes-carousel .owl-nav');
                        var item_index = e.item.index;
                        var item_count = e.item.count;
                        var last_vis_item_index = items_per_page + item_index;
                        //$('.classes-carousel').find('.active').not('').removeClass
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
                };
            $('.classes .nav li:first-of-type').addClass('active');
            $('.classes .tab-content .tab-pane:first-of-type').addClass('in active');
//                $('.classes .tab-content .tab-pane:first-of-type .classes-carousel').owlCarousel(options);
//                $('.classes .nav a').on('shown.bs.tab',function(){
//                    var thisTag = $(this);
//                    var thisTabId = thisTag.data('target');
//                    var owlClasses = $(thisTabId).find('.classes-carousel');
//                    owlClasses.trigger('destroy.owl.carousel');
//                    owlClasses.html(owlClasses.find('.owl-stage-outer').html()).removeClass('owl-loaded');
//                    owlClasses.owlCarousel(options);
//                });
            ");
            ?>
        </div>
        <?php
    else:
        ?>
        <div class="not-found">
            <div class="inner-flex">
                <h3><?= Yii::t('app', 'There is no class available at the moment.') ?></h3>
                <p><?= Yii::t('app',"The Schedule for Future Classes Will Be Announced Soon.\nShould You Need More Information, Please Kindly Call the Institute.") ?></p>
            </div>
        </div>
        <?php
    endif;
    ?>
</div>