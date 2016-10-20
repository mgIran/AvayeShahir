<?php
/* @var $this SiteController */
/* @var $FAQCategories FaqCategories */
?>
<!--<script>-->
<!--    $(function () {-->
<!--        $(".main-menu.affix").affix({-->
<!--            offset: {-->
<!--                top: 0-->
<!--            }-->
<!--        });-->
<!--    })-->
<!--</script>-->
<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><?= Yii::t('app','FAQ') ?></h2>
    </div>
</div>
<div class="page-content courses" data-spy="scroll" data-target="#myScrollspy" data-offset-top="80">
    <div class="container faq-section">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <!--Headings-->
            <div id="myScrollspy">
                <div class="affix-top"  data-spy="affix" data-offset-top="160" data-offset-bottom="600">
                    <h3><?= Yii::t('app','Heading') ?></h3>
                    <ul class="main-menu nav nav-stacked">
                        <?php
                        $i = 1;
                        foreach ($FAQCategories as $category):
                            echo '<li>';
                            echo '<a class="scroll-link" href="#cat'.$category->id.'">'.$category->title.'</a>';
                            echo '<ol>';
                            $k=1;
                            foreach ($category->faqs as $faq):
                                echo '<li>';
                                echo '<a class="scroll-link" href="#cat'.$category->id.'-q'.$faq->id.'">'.$faq->title.'</a>';
                                echo'</li>';
                                $k++;
                            endforeach;
                            echo'</ol>';
                            echo'</li>';
                            $i++;
                        endforeach;
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 faq-section">
            <div class="contents">
                <ul>
                    <?php
                    $i = 1;
                    foreach ($FAQCategories as $category):
                        echo '<li>';
                        echo '<h2 id="cat'.$category->id.'"><span><span class="row-num">'.$i.'.&nbsp;&nbsp;</span>'.$category->title.'</span></h2>';
                        echo '<ol>';
                        $k=1;
                        foreach ($category->faqs as $faq):
                            echo '<li>';
                            echo '<h3 id="cat'.$category->id.'-q'.$faq->id.'"><span class="row-num">'.$i.'. '.$k.'.&nbsp;&nbsp;</span>'.$faq->title.'</h3>';
                            $purifier = new CHtmlPurifier();
                            $purifier->setOptions(array(
                                'HTML.Allowed'=> 'p,a[href|target],b,i,br',
                            ));
                            $text = $purifier->purify($faq->body);
                            echo '<div class="faq-text">'.$text.'</div>';
                            echo'</li>';
                            $k++;
                        endforeach;
                        echo'</ol>';
                        echo'</li>';
                        $i++;
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>