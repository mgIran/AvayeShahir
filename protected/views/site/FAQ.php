<?php
/* @var $this SiteController */
/* @var $FAQCategories FaqCategories */
?>


<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><?= Yii::t('app','FAQ') ?></h2>
    </div>
</div>
<div class="page-content courses">
    <div class="container">
        <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-lg-push-1 col-md-push-1 faq-section">
            <!--Headings-->
            <h3><?= Yii::t('app','Heading') ?></h3>
            <ul>
                <?php
                $i = 1;
                foreach ($FAQCategories as $category):
                    echo '<li>';
                    echo '<a class="scroll-link" href="#cat'.$category->id.'"><span class="row-num">'.$i.'.&nbsp;&nbsp;</span>'.$category->title.'</a>';
                    echo '<ol>';
                    $k=1;
                    foreach ($category->faqs as $faq):
                        echo '<li>';
                        echo '<a class="scroll-link" href="#cat'.$category->id.'-q'.$faq->id.'"><span class="row-num">'.$i.'. '.$k.'.&nbsp;&nbsp;</span>'.$faq->title.'</a>';
                        echo'</li>';
                        $k++;
                    endforeach;
                    echo'</ol>';
                    echo'</li>';
                    $i++;
                endforeach;
                ?>
            </ul>
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