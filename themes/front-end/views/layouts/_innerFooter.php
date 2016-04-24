<footer class="footer">
    <div class="container">
        <div class="info-box">
            <div class="col-md-4">
                <p>
                    <i class="map-point"></i>
                    <span></span>
                </p>
                <p>
                    <i class="phone"></i>
                    <span></span>
                </p>
                <p>
                    <i class="email"></i>
                    <span>info@avayeshar.com</span>
                </p>
            </div>
            <div class="col-md-4">
                <h4>ما را دنبال کنید</h4>
                <p>
                    <a href="#" class="social-media facebook"></a>
                    <a href="#" class="social-media twitter"></a>
                    <a href="#" class="social-media google-plus"></a>
                </p>
                <p class="copyright">همهٔ حقوق برای موسسه پردیس آوای شهیر محفوظ است. ©‏ <?= JalaliDate::date('Y',time()) ?> </p>
            </div>
            <div class="col-md-4">
                <?= $this->renderPartial('//layouts/_map'); ?>
            </div>
        </div>
    </div>
</footer>