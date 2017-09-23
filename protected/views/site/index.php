<?
/* @var $this SiteController */
/* @var $courses Courses[] */
/* @var $newsProvider CActiveDataProvider */
/* @var $classes Classes[] */
/* @var $personnel Personnel[] */
/* @var $teachers Users[] */
/* @var $form CActiveForm */
/* @var $aboutText Pages */
?>
<section class="courses" id="courses">
    <div class="container">
        <h3 class="yekan-text"><?= Yii::t('app' ,'Education Courses & Resources') ?></h3>
        <div class="course-carousel">
            <?
            if($courses) :
                $baseUrl = Yii::app()->theme->baseUrl;
                Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/owl.carousel.min.js');
                Yii::app()->clientScript->registerScript("owl-carousel-script","
                $('.course-carousel').owlCarousel({
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
                            stagePadding : 15
                        },
                        459 :{
                            items:2,
                            nav : true,
                            margin :10,
                            dots : false,
                            stagePadding : 0
                        },
                        1025 :{
                            items:2,
                            nav : true,
                            margin :40,
                            dots : false,
                            stagePadding : 0
                        },
                        1201 :{
                            items:3,
                            nav : true,
                            margin :10,
                            dots : false,
                            stagePadding : 0
                        },
                        1401 :{
                            items:3,
                            nav : true,
                            margin :40,
                            dots : false,
                            stagePadding : 0
                        },
                        1601 :{
                            items:4,
                            nav : true,
                            margin :10,
                            dots : false,
                            stagePadding : 0
                        },
                    },
                    onTranslated: $(this).on('translated.owl.carousel', function(e) {
                        var items_per_page = e.page.size;
                        var nav_container = $('.course-carousel .owl-nav');
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
                foreach($courses as $course):
                    ?>
                    <div class="course">
                        <div class="three-dots-container">
                            <div class="three-dots"></div>
                        </div>
                        <?php $this->renderPartial('_course_categories',array('model' => $course)) ?>
                        <div class="course-pic" title="<?= $course->title ?>">
                            <div class="overlay">
                            </div>
                            <a href="<?= Yii::app()->createUrl('/courses/'.urlencode($course->getValueLang('title', 'en')).'/'.$course->id); ?>">
                                <img src="<?= Yii::app()->baseUrl.'/uploads/courses/'.$course->pic; ?>" alt="<?= $course->title ?>">
                            </a>
                        </div>
                        <div class="course-detail container-fluid">
                            <h4><a href="<?= Yii::app()->createUrl('/courses/'.urlencode($course->getValueLang('title', 'en')).'/'.$course->id); ?>"><?= $course->title ?></a></h4>

                            <p class="text">
                                <?= strip_tags($course->summary) ?>
                                <span class="paragraph-end"></span>
                            </p>
                            <a href="<?= Yii::app()->createUrl('/courses/'.urlencode($course->getValueLang('title', 'en')).'/'.$course->id); ?>"
                               data-toggle="tooltip" data-placement="<?= Yii::app()->language == 'fa'?'right':'left';?>" title="<?= Yii::t('app','Course Details') ?>"
                               class="btn pull-left"><?= Yii::t('app','Details')?></a>
                        </div>
                    </div>
                    <?
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
<?php
if($newsProvider->totalItemCount):
?>
<section class="news-section" id="news">
    <div class="container">
        <h3 class="yekan-text"><?= Yii::t('app' ,'News') ?></h3>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12 pull-left category-list">
            <?php
            $this->widget('ext.dropDown.dropDown', array(
                'id' => 'news_categories',
                'name' => 'news',
                'label' => Yii::t('app','News Category'),
                'data' => $this->getNewsCategories(),
                'caret' => '<i class="caret"></i>',
                'emptyOpt' => false,
                'onchange' => 'js:
                            var $s = {id};
                            var $base = \''.Yii::app()->createUrl('/').'/\';
                            location.href = $base+$s;
                        ',
            ));
            ?>
            </div>
        </div>
        <div class="news-container">
            <?php
            $this->widget("zii.widgets.CListView",array(
                'id' => 'news-list',
                'dataProvider' => $newsProvider,
                'itemView' => 'news.views.manage._view',
                'template' => '{items}',
            ));
            ?>
            <?php
            if(News::model()->count(News::getValidNews()) > 4):
            ?>
                <a class="more-btn" href="<?= $this->createUrl('/news') ?>">
                <?= Yii::t('app','See More') ?>
                <div class="bounces">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>
            <?php
            endif;
            ?>
        </div>
    </div>
</section>
<?php
endif;
?>
<section class="signup" id="signup">
    <div class="mask"></div>
    <?= $this->renderPartial("//layouts/_loading");?>
    <div class="container-fluid">
        <h2 class="yekan-text text-center"><?= Yii::t('app','Sign Up Account') ?></h2>

        <?php
        $signUpModel = new Users('agreeTerms');
        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'register-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'afterValidate' => 'js:function(form ,data ,hasError){
                    if(!hasError)
                    {
                        var form = $("#register-form");
                        var loading = $(".signup .loading-container");
                        var url = \''.Yii::app()->createUrl('/register').'\';
                        submitAjaxForm(form ,url ,loading ,"if(html.state == \'ok\') location.reload();");
                    }
                }'
            ),
            'htmlOptions' => array(
                'class' => 'form-group'
            )
        ));
        Yii::app()->clientScript->registerScript('registerForm','
            document.getElementById("register-form").reset();
        ');
        echo CHtml::hiddenField('ajax','register-form');
        ?>
            <div class="center-block box">
                <?= $this->renderPartial("//layouts/_flashMessage");?>
                <div class="relative">
                    <?php echo $form->emailField($signUpModel,'email' ,array(
                        'placeholder' => Yii::t('app','Email'),
                        'class' => 'text-field'
                    ));
                    echo $form->error($signUpModel,'email',array('class'=>'errorMessage tip'));?>
                </div>
                <div class="relative">
                    <?php echo $form->passwordField($signUpModel,'password',array(
                        'placeholder' => Yii::t('app','Password'),
                        'class' => 'text-field'
                    ));
                    echo $form->error($signUpModel,'password',array('class'=>'errorMessage tip'));?>
                </div>
                <div class="relative">
                    <?php echo $form->telField($signUpModel,'phone',array(
                        'placeholder' => Yii::t('app','Phone'),
                        'class' => 'text-field',
                        'max-length' => 11
                    ));
                    echo $form->error($signUpModel,'phone',array('class'=>'errorMessage tip'));?>
                </div>
                <div class="relative">
                    <div class="checkbox">
                        <label>
                            <?= $form->checkBox($signUpModel,'agreeTerms'); ?>
                            <span>
                                <?= Yii::t('app' ,'I agree with the <a data-toggle="modal" data-target="#terms-modal" href="#">Terms and Policies</a>')?>
                            </span>
                        </label>
                        <? echo $form->error($signUpModel,'agreeTerms',array('class'=>'errorMessage tip'));?>
                    </div>
                </div>
                <?= CHtml::submitButton(Yii::t('app','Sign Up'),array('class'=>"button-field btn")); ?>
            </div>
        <?php $this->endWidget(); ?>
    </div>
</section>
<?
if($classes) :
?>
<section class="classes" id="classes">
    <div class="container">
        <h3 class="yekan-text"><?= Yii::t('app' ,'Offered Classes') ?></h3>
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
                            <a href="#">
                                <h4 data-toggle="tooltip" data-placement="top" title="<?= $class->title ?>"><?= $class->title ?></h4>
                            </a>
                            <section class="progress" data-toggle="tooltip" title="<?= Yii::t('app','Class Capacity')?>">
                                <div class="progress-bar progress-bar-<?php
                                if($class->capacity - $class->remainingCapacity <= 3) echo 'success';
                                else if($class->capacity - $class->remainingCapacity <15) echo 'warning';
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
<!--                            <div class="text-danger remain-capacity">--><?//= Yii::t('app','Remaining Capacity').': '.$class->remainingCapacity ?><!--</div>-->
                        </div>
                        <div class="class-detail container-fluid">
                            <div class="full text-nowrap">
                                <span><?= Yii::t('app','Course') ?>:&nbsp;</span>
                                <a href="<?= Yii::app()->createUrl('/courses/'.urlencode($class->course->getValueLang('title', 'en')).'/'.$class->course->id); ?>">
                                    <?php echo $class->course->title ?>
                                </a>
                            </div>
                            <div class="full">
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
                            <div class="full">
                                    <span><?= Yii::t('app','Registration') ?>:</span><br><?= Yii::t('app','from') ?>&nbsp;<span><?php echo Yii::app()->language=='fa'?Controller::parseNumbers(JalaliDate::date("Y/m/d",$class->startSignupDate)):date("Y/m/d",$class->startSignupDate); ?></span>&nbsp;<?= Yii::t('app','up to') ?>&nbsp;<span><?php echo Yii::app()->language=='fa'?Controller::parseNumbers(JalaliDate::date("Y/m/d",$class->endSignupDate)):date("Y/m/d",$class->endSignupDate) ?></span>
                            </div>
                            <div class="full">
                                    <span><?= Yii::t('app','Start & End of the Course') ?>:</span><br><?= Yii::t('app','from') ?>&nbsp;<span><?php echo Yii::app()->language=='fa'?Controller::parseNumbers(JalaliDate::date("Y/m/d",$class->startClassDate)):date("Y/m/d",$class->startClassDate) ?></span><span>&nbsp;<?= Yii::t('app','to') ?>&nbsp;</span><span><?php echo Yii::app()->language=='fa'?Controller::parseNumbers(JalaliDate::date("Y/m/d",$class->endClassDate)):date("Y/m/d",$class->endClassDate) ?></span>
                            </div>
                            <div class="full">
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
                                            'HTML.AllowedAttributes'=> 'style,id,class,src',
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
    </div>
</section>
<?
endif;
?>
<?
if($this->message):
?>
<section class="message-box">
    <div class="container">
        <div class="alert fade in message"><button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button><?= $this->message ?></div>
    </div>
</section>
<?php
endif;
?>

<section class="persons">
    <div class="bg">
        <div class="icons-set left"></div>
        <div class="icons-set right"></div>
    </div>
    <div class="container">
        <?php
        if($personnel) {

//            ?>
<!--            <div class="--><?//= $teachers?'':'center-block' ?><!-- col-lg-6 col-md-6 col-sm-8 col-xs-12  partners" id="staff">-->
<!--                <h3 class="yekan-text">--><?//= Yii::t('app', 'Staff') ?><!--</h3>-->
<!---->
<!--                <div class="slider">-->
<!--                    --><?php
//                    foreach($personnel as $person):
//                    $socialLinks = CJSON::decode($person->social_links);
//                        ?>
<!--                    <div class="person-item">-->
<!--                        <div class="image">-->
<!--                            <img src="--><?//= Yii::app()->baseUrl.'/uploads/teachers/'.$person->avatar ?><!--" alt="--><?//= CHtml::encode($person->fullName) ?><!--">-->
<!---->
<!--                            <div class="img-overlay"></div>-->
<!--                        </div>-->
<!--                        <span class="name">--><?//= CHtml::encode($person->fullName) ?><!--</span>-->
<!--                        <span class="job">--><?//= CHtml::encode($person->grade) ?><!--</span>-->
<!---->
<!--                        <div class="socials">-->
<!--                            <a href="--><?//= $person->email ?><!--" class="email" title="--><?//= Yii::t('app','Email') ?><!--"></a>-->
<!--                            <a href="--><?//= $socialLinks[0]['value'] ?><!--" class="facebook" title="--><?//= Yii::t('app','Facebook') ?><!--"></a>-->
<!--                            <a href="--><?//= $socialLinks[1]['value'] ?><!--" class="twitter" title="--><?//= Yii::t('app','Twitter') ?><!--"></a>-->
<!--                        </div>-->
<!--                        <a href="--><?//= Yii::app()->createUrl('/personnel/'.$person->id.'/'.urlencode($person->getFullName())) ?><!--" class="person-link" title="--><?//= CHtml::encode($person->fullName) ?><!--"></a>-->
<!--                    </div>-->
<!--                    --><?php
//                    endforeach;
//                    ?>
<!--                </div>-->
<!--            </div>-->
<!--            --><?//
        }
        ?>
        <?php
        if($teachers) {
            ?>
            <div class="center-block col-lg-10 col-md-10 col-sm-8 col-xs-12 teachers" id="teachers">
                <h3 class="yekan-text"><?= Yii::t('app', 'Teachers') ?></h3>

                <div class="teacher-carousel slider">
                    <?php
                    foreach($teachers as $teacher):
                        $socialLinks = CJSON::decode($teacher->teacherDetails->social_links);
                        ?>
                        <div class="person-item col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="image">
                                <a href="<?= Yii::app()->createUrl('/teachers/'.$teacher->id.'/'.urlencode($teacher->teacherDetails->getFullName())) ?>" class="person-link"></a>
                                <?
                                if($teacher->teacherDetails->avatar):
                                ?>
                                    <img src="<?= Yii::app()->baseUrl.'/uploads/teachers/'.$teacher->teacherDetails->avatar ?>" alt="<?= CHtml::encode($teacher->teacherDetails->getFullName()) ?>">
                                <?
                                else:
                                ?>
                                    <div class="img-default"></div>
                                <?
                                endif;
                                ?>

                                <div class="img-overlay"></div>
                            </div>
                            <span class="name"><?= CHtml::encode($teacher->teacherDetails->getFullName()) ?></span>
                            <span class="job"><?= CHtml::encode($teacher->teacherDetails->grade) ?></span>

                            <div class="socials">
                                <a href="<?= $teacher->email ?>" class="email" title="<?= Yii::t('app','Email') ?>"></a>
                                <a href="<?= $socialLinks[0]['value'] ?>" class="facebook" title="<?= Yii::t('app','Facebook') ?>"></a>
                                <a href="<?= $socialLinks[1]['value'] ?>" class="twitter" title="<?= Yii::t('app','Twitter') ?>"></a>
                            </div>
                            <a href="<?= Yii::app()->createUrl('/teachers/'.$teacher->id.'/'.urlencode($teacher->teacherDetails->getFullName())) ?>" class="person-link" title="<?= CHtml::encode($teacher->teacherDetails->getFullName()) ?>"></a>
                        </div>
                        <?php
                    endforeach;
                    ?>
                </div>
            </div>
            <?
        }
        ?>
    </div>
</section>

<section class="about" id="about">
    <div class="container">
        <h3 class="yekan-text"><?= Yii::t('app','About Avaye Shahir') ?></h3>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-container">
                <div class="text">
<!--                --><?//
//                $aboutText->summary = str_ireplace('<br />','#br#',$aboutText->summary);
//                $text = strip_tags($aboutText->summary);
//                $text = str_ireplace('#br#','<br>',$text);
//                $length = mb_strlen($text,'utf8');
//                if($length > 280) {
//                    $length = ceil($length / 2);
//                    $words = explode(" ", $text);
//                    $c = count($words);
//                    $l = 0;
//                    $colOutput = '';
//                    for($i = 1; $i <= 2; $i++) {
//                        $new_string = "";
//                        $colOutput .= "<p class=\"paragraph col-lg-6 col-md-6 col-sm-6 col-xs-12\">";
//                        for($g = $l; $g < $c; $g++) {
//                            if(mb_strlen($new_string,'utf8') <= $length || $i == 2)
//                                $new_string .= $words[$g]." ";
//                            else {
//                                $l = $g;
//                                break;
//                            }
//                        }
//                        $colOutput .= $new_string;
//                        $colOutput .= "</p>";
//                    }
//                    echo $colOutput;
//                }else {
//                    echo "<p class=\"paragraph col-lg-6 col-md-6 col-sm-6 col-xs-12\">".$text."</p>";
//                    echo "<p class=\"paragraph col-lg-6 col-md-6 col-sm-6 col-xs-12\"></p>";
//                }
//                ?>
                <?= $aboutText->summary  ?>
            </div>

        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 licenses-container">
            <div class="col-md-12"><img id='nbpegwmdgwmdgwmdsgui' style='cursor:pointer' onclick='window.open("https://trustseal.enamad.ir/Verify.aspx?id=29990&p=wkynjzpgjzpgjzpgdrfs", "Popup","toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30")' alt='' src='https://trustseal.enamad.ir/logo.aspx?id=29990&p=qesgzpfvzpfvzpfvgthv'/></div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-12">
                <a class="btn btn-info btn-raised" href="<?= Yii::app()->createUrl('/gallery'); ?>">
                    <?= Yii::t('app' ,'Pictures Gallery') ?>
                </a>
                <a class="btn btn-success btn-raised" href="<?= Yii::app()->createUrl('/forum'); ?>">
                    <?= Yii::t('app' ,'Forum') ?>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div id="terms-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <?= $termsText->summary ?>
            </div>
        </div>

    </div>
</div>