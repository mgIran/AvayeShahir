$(function() {
    $.material.init();
    if($(window).scrollTop() > 100)
        $("header.header").addClass('scroll-mode');

    $("html").niceScroll({
        railalign:'right',
        rtlmode:true,
        hwacceleration:false,
        zindex:1000,
        cursorcolor:'rgba(0,0,0,0.4)',
        cursorborder:'none'
    });

    $("body").on("click" ,"[href^='#']",function(e) {
        e.preventDefault();
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
                    $("#" + key + "_em_").show().html(value.toString());
                });
            }else
                eval(callback);
        }
    });
}