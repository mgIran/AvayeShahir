<?
/* @var $this SiteController */
/* @var $slides Slideshow[] */
/* @var $courses Courses[] */
/* @var $newsProvider CActiveDataProvider */
/* @var $writingsProvider CActiveDataProvider */
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
if($writingsProvider->totalItemCount):
?>
<section class="news-section" id="writings">
    <div class="container">
        <h3 class="yekan-text"><?= Yii::t('app' ,'Writings') ?> <small class="text-danger"><?= Yii::t('app','new') ?></small></h3>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12 pull-left category-list">
            <?php
            $this->widget('ext.dropDown.dropDown', array(
                'id' => 'writings_categories',
                'name' => 'news',
                'label' => Yii::t('app','Writings Category'),
                'data' => $this->getWritingCategories(),
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
                'dataProvider' => $writingsProvider,
                'itemView' => 'writings.views.manage._view',
                'template' => '{items}',
            ));
            ?>
        </div>
    </div>
</section>
<?php
endif;
?>
<?php /*
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
endif;*/
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
<section class="classes" id="classes">
    <?php $this->renderPartial('_classes',compact('classes')); ?>
</section>
<?
if($classes && $this->message):
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