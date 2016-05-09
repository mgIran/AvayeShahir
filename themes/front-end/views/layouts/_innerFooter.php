<footer class="footer">
    <div class="container">
        <div class="info-box">
            <div class="col-md-4">
                <p>
                    <i class="map-point"></i>
                    <span>تهران: خیابان شهید بهشتی، خ سرفراز (قائم مقام فراهانی) کوچه دهم، پلاک 9، واحد 1
</span>
                </p>
                <p>
                    <i class="phone"></i>
                    <span class="phone-number">021 88730902 - 021 88736668 - 021 88502049</span>
                </p>
                <p>
                    <i class="email"></i>
                    <span>pardis@avayeshahir.com</span>
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