$(function() {
    $.material.init();
    if($(window).scrollTop() > 100)
        $("header.header").addClass('scroll-mode');

    // fade out alert messages
    setInterval(function(){
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 10000);

    $("body").on("click" ,".scroll-link[href^='#']",function(e) {
        e.preventDefault();
        if($(window).width() < 768)
        {
            $('.navTrigger').removeClass("clicked").find('.lines').removeClass("close");
            $("html,body").removeClass("overflow");
        }
        var href = $(this).attr('href');
        if(href.substr(1,href.length))
            $('html, body').animate({
                scrollTop: ($(href).offset().top-70)
            },1000,'easeOutCubic');
    });

    $(window).scroll(function() {
        $("[data-toggle='tooltip']").tooltip('hide');
        if ($(this).scrollTop() > 100)
            $("header.header").addClass('scroll-mode');
        else
            $("header.header").removeClass('scroll-mode');
    });

    $("[data-toggle='tooltip']").tooltip({
        trigger:'hover'
    });
    $(".category [data-toggle='tooltip']").tooltip({
        trigger:'hover',
        template : '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner large"></div></div>'
    });

    $("body").on('click','.navTrigger',function(){
        $(this).toggleClass("clicked");
        $(this).find('.lines').toggleClass("close");
        $("html,body").toggleClass("overflow");
    });
});


function submitAjaxForm(form ,url ,loading ,callback) {
    loading = typeof loading !== 'undefined' ? loading : null;
    callback = typeof callback !== 'undefined' ? callback : null;
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        dataType: "json",
        beforeSend: function () {
            if(loading)
                loading.show();
        },
        success: function (html) {
            if(loading)
                loading.hide();
            if (typeof html === "object" && typeof html.state === 'undefined') {
                $.each(html, function (key, value) {
                    $("#" + key + "_em_").show().html(value.toString()).parent().removeClass('success').addClass('error');
                });
            }else
                eval(callback);
        }
    });
}