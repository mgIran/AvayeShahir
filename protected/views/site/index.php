<?
$baseUrl = Yii::app()->theme->baseUrl;
Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/jquery.mousewheel.min.js');
Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/owl.carousel.min.js');
Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/jquery.easy-ticker.min.js');
Yii::app()->clientScript->registerScript("owl-carousel-script","
        $('.course-carousel').owlCarousel({
            rtl:true,
            nav:true,
            navText:['<span class=\"arrow\"></span>','<span class=\"arrow\"></span>'],
            margin:30,
            responsive : {
                0 : {
                    items:3
                }
            }
        });");
Yii::app()->clientScript->registerScript("easyTicker-scripts","
        $('.persons .teachers .slider').easyTicker({
            direction: 'down',
            easing: 'swing',
            speed: 'slow',
            interval: 10000,
            height: 355,
            visible: 1,
            mousePause: 1,
            controls: {
                up: '.teacher-up',
                down: '.teacher-down'
            }
        }).data('easyTicker');

        $('.persons .partners .slider').easyTicker({
            direction: 'down',
            easing: 'swing',
            speed: 'slow',
            interval: 10000,
            height: 355,
            visible: 1,
            mousePause: 1,
            controls: {
                up: '.partner-up',
                down: '.partner-down'
            }
        }).data('easyTicker');");

?>

<section class="courses">
    <div class="container">
        <h3 class="yekan-text"><?= $model->title; ?></h3>
        <div class="course-carousel">
            <div class="course">
                <div class="course-pic">
                    <img src="../images/Non-Traditional-Student-at-Work-goodluz.jpg">
                </div>
                <div class="course-detail container-fluid">
                    <h4><a href="#">دوره های بزرگ سالان</a></h4>
                    <p class="text">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                        <span class="paragraph-end"></span>
                    </p>
                    <a href="#" class="btn pull-left">جزئیات</a>
                </div>
            </div>
            <div class="course">
                <div class="course-pic">
                    <img src="../images/lzeaxqbhifexdgseituh.jpg">
                </div>
                <div class="course-detail container-fluid">
                    <h4><a href="#">دوره های کودکان</a></h4>
                    <p class="text">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                        <span class="paragraph-end"></span>
                    </p>
                    <a href="#" class="btn pull-left">جزئیات</a>
                </div>
            </div>
            <div class="course">
                <div class="course-pic">
                    <img src="../images/Eiffel--4f11fe9aeb680_hires.jpg">
                </div>
                <div class="course-detail container-fluid">
                    <h4><a href="#">دوره های فرانسه</a></h4>
                    <p class="text">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                        <span class="paragraph-end"></span>
                    </p>
                    <a href="#" class="btn pull-left">جزئیات</a>
                </div>
            </div>
            <div class="course">
                <div class="course-pic">
                    <img src="../images/6780_IELTS_Scholarship.jpg">
                </div>
                <div class="course-detail container-fluid">
                    <h4><a href="#">دوره های IELTS</a></h4>
                    <p class="text">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                        <span class="paragraph-end"></span>
                    </p>
                    <a href="#" class="btn pull-left">جزئیات</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="signup" id="signup">
    <div class="mask"></div>
    <div class="container-fluid">
        <h2 class="yekan-text text-center">ساخت حساب کاربری</h2>
        <form action="/signup" method="post" class="form-group">
            <div class="center-block box">
                <input type="text" class="text-field" placeholder="پست الکترونیکی">
                <input type="password" class="text-field" placeholder="کلمه عبور">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"><span>با <a href="#">شرایط و قوانین</a> سایت موافقم.</span>
                    </label>
                </div>
                <button type="submit" class="button-field btn">ثبت نام</button>
            </div>
        </form>
    </div>
</section>
<section class="persons">
    <div class="bg">
        <div class="icons-set left"></div>
        <div class="icons-set right"></div>
    </div>
    <div class="container">
        <div class="col-md-6 teachers">
            <h3 class="yekan-text">اساتید آوای شهیر</h3>
            <div class="slider">
                <ul>
                    <li class="person-item">
                        <div class="image">
                            <img src="../images/p1.jpg">
                            <div class="img-overlay"></div>
                        </div>
                        <span class="name">مهندس محمدرضا شعبانعلی</span>
                        <span class="job">کارشناس ارشد زبان فرانسه</span>
                        <div class="socials">
                            <a href="/email" class="email" title="Email"></a>
                            <a href="/facebook" class="facebook" title="Facebook"></a>
                            <a href="/twitter" class="twitter" title="Twitter"></a>
                        </div>
                        <a href="#" class="person-link" title="PERSON NAME"></a>
                    </li>
                    <li class="person-item">
                        <div class="image">
                            <img src="../images/p2.jpg">
                            <div class="img-overlay"></div>
                        </div>
                        <span class="name">دکتر سید جواد طباطبایی</span>
                        <span class="job">دکترای زبان انگلیسی</span>
                        <div class="socials">
                            <a href="/email" class="email" title="Email"></a>
                            <a href="/facebook" class="facebook" title="Facebook"></a>
                            <a href="/twitter" class="twitter" title="Twitter"></a>
                        </div>
                        <a href="#" class="person-link" title="PERSON NAME"></a>
                    </li>
                    <li class="person-item">
                        <div class="image">
                            <img src="../images/p3.jpg">
                            <div class="img-overlay"></div>
                        </div>
                        <span class="name">مهندس محسن ریاحی</span>
                        <span class="job">کارشناس ارشد زبان انگلیسی</span>
                        <div class="socials">
                            <a href="/email" class="email" title="Email"></a>
                            <a href="/facebook" class="facebook" title="Facebook"></a>
                            <a href="/twitter" class="twitter" title="Twitter"></a>
                        </div>
                        <a href="#" class="person-link" title="PERSON NAME"></a>
                    </li>
                    <li class="person-item">
                        <div class="image">
                            <img src="../images/p1.jpg">
                            <div class="img-overlay"></div>
                        </div>
                        <span class="name">مهندس محمدرضا شعبانعلی</span>
                        <span class="job">کارشناس ارشد زبان فرانسه</span>
                        <div class="socials">
                            <a href="/email" class="email" title="Email"></a>
                            <a href="/facebook" class="facebook" title="Facebook"></a>
                            <a href="/twitter" class="twitter" title="Twitter"></a>
                        </div>
                        <a href="#" class="person-link" title="PERSON NAME"></a>
                    </li>
                    <li class="person-item">
                        <div class="image">
                            <img src="../images/p2.jpg">
                            <div class="img-overlay"></div>
                        </div>
                        <span class="name">دکتر سید جواد طباطبایی</span>
                        <span class="job">دکترای زبان انگلیسی</span>
                        <div class="socials">
                            <a href="/email" class="email" title="Email"></a>
                            <a href="/facebook" class="facebook" title="Facebook"></a>
                            <a href="/twitter" class="twitter" title="Twitter"></a>
                        </div>
                        <a href="#" class="person-link" title="PERSON NAME"></a>
                    </li>
                    <li class="person-item">
                        <div class="image">
                            <img src="../images/p3.jpg">
                            <div class="img-overlay"></div>
                        </div>
                        <span class="name">مهندس محسن ریاحی</span>
                        <span class="job">کارشناس ارشد زبان انگلیسی</span>
                        <div class="socials">
                            <a href="/email" class="email" title="Email"></a>
                            <a href="/facebook" class="facebook" title="Facebook"></a>
                            <a href="/twitter" class="twitter" title="Twitter"></a>
                        </div>
                        <a href="#" class="person-link" title="PERSON NAME"></a>
                    </li>
                </ul>
            </div>
            <div class="controls">
                <button class="teacher-up btn"><i class="icon"></i></button>
                <button class="teacher-down btn"><i class="icon"></i></button>
            </div>
        </div>
        <div class="col-md-6 partners">
            <h3 class="yekan-text">همکاران آوای شهیر</h3>
            <div class="slider">
                <ul>
                    <li class="person-item">
                        <div class="image">
                            <img src="../images/p1.jpg">
                            <div class="img-overlay"></div>
                        </div>
                        <span class="name">مهندس محمدرضا شعبانعلی</span>
                        <span class="job">کارشناس ارشد زبان فرانسه</span>
                        <div class="socials">
                            <a href="/email" class="email" title="Email"></a>
                            <a href="/facebook" class="facebook" title="Facebook"></a>
                            <a href="/twitter" class="twitter" title="Twitter"></a>
                        </div>
                        <a href="#" class="person-link" title="PERSON NAME"></a>
                    </li>
                    <li class="person-item">
                        <div class="image">
                            <img src="../images/p2.jpg">
                            <div class="img-overlay"></div>
                        </div>
                        <span class="name">دکتر سید جواد طباطبایی</span>
                        <span class="job">دکترای زبان انگلیسی</span>
                        <div class="socials">
                            <a href="/email" class="email" title="Email"></a>
                            <a href="/facebook" class="facebook" title="Facebook"></a>
                            <a href="/twitter" class="twitter" title="Twitter"></a>
                        </div>
                        <a href="#" class="person-link" title="PERSON NAME"></a>
                    </li>
                    <li class="person-item">
                        <div class="image">
                            <img src="../images/p3.jpg">
                            <div class="img-overlay"></div>
                        </div>
                        <span class="name">مهندس محسن ریاحی</span>
                        <span class="job">کارشناس ارشد زبان انگلیسی</span>
                        <div class="socials">
                            <a href="/email" class="email" title="Email"></a>
                            <a href="/facebook" class="facebook" title="Facebook"></a>
                            <a href="/twitter" class="twitter" title="Twitter"></a>
                        </div>
                        <a href="#" class="person-link" title="PERSON NAME"></a>
                    </li>
                    <li class="person-item">
                        <div class="image">
                            <img src="../images/p1.jpg">
                            <div class="img-overlay"></div>
                        </div>
                        <span class="name">مهندس محمدرضا شعبانعلی</span>
                        <span class="job">کارشناس ارشد زبان فرانسه</span>
                        <div class="socials">
                            <a href="/email" class="email" title="Email"></a>
                            <a href="/facebook" class="facebook" title="Facebook"></a>
                            <a href="/twitter" class="twitter" title="Twitter"></a>
                        </div>
                        <a href="#" class="person-link" title="PERSON NAME"></a>
                    </li>
                    <li class="person-item">
                        <div class="image">
                            <img src="../images/p2.jpg">
                            <div class="img-overlay"></div>
                        </div>
                        <span class="name">دکتر سید جواد طباطبایی</span>
                        <span class="job">دکترای زبان انگلیسی</span>
                        <div class="socials">
                            <a href="/email" class="email" title="Email"></a>
                            <a href="/facebook" class="facebook" title="Facebook"></a>
                            <a href="/twitter" class="twitter" title="Twitter"></a>
                        </div>
                        <a href="#" class="person-link" title="PERSON NAME"></a>
                    </li>
                    <li class="person-item">
                        <div class="image">
                            <img src="../images/p3.jpg">
                            <div class="img-overlay"></div>
                        </div>
                        <span class="name">مهندس محسن ریاحی</span>
                        <span class="job">کارشناس ارشد زبان انگلیسی</span>
                        <div class="socials">
                            <a href="/email" class="email" title="Email"></a>
                            <a href="/facebook" class="facebook" title="Facebook"></a>
                            <a href="/twitter" class="twitter" title="Twitter"></a>
                        </div>
                        <a href="#" class="person-link" title="PERSON NAME"></a>
                    </li>
                </ul>
            </div>
            <div class="controls">
                <button class="partner-up btn"><i class="icon"></i></button>
                <button class="partner-down btn"><i class="icon"></i></button>
            </div>
        </div>
    </div>
</section>
<section class="about">
    <div class="container">
        <h3 class="yekan-text">درباره پردیس</h3>
        <div class="col-md-8 text-container">
            <div class="text">
                <p class="paragraph col-md-6">مرکز زبان آریانپورکه تنها دارنده مجوز از وزارت آموزش و پرورش به ایـن نام در تهران می باشد، با مطالعات و برنامه ریزی های جـامـع آمـوزشـی و بـا سـالها سابقه در برگزاری دوره های IELTS,TOEFL  تا کـنون گامهای بلند و جامعی در جهت ارایه آموزش صحیح و موثر زبان انگلیسی برداشته است .</p>
                <p class="paragraph col-md-6">در هـمین راسـتا با ایــجاد محیط آموزشی استاندارد و بهره گیری از تکنولوژی جـدید آمـوزش زبان و استادان مجرب، با بالاترین آمار نمرات در آزمونهای فوق همواره  با آغوش باز پذیرای زبان آموزان عزیز می باشد. </p>
            </div>
        </div>
        <div class="col-md-4 licenses-container">
            <div class="col-md-6"><img src="../images/rasaneh.jpg"></div>
            <div class="col-md-6"><img src="../images/enamad.jpg"></div>
        </div>
    </div>
</section>
