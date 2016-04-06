$(function() {

    $("html").niceScroll({
        railalign:'left',
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
            },1000);
    });

    $(window).scroll(function(){
        if($(this).scrollTop() > 100)
            $("header.header").addClass('scroll-mode');
        else
            $("header.header").removeClass('scroll-mode');
    });
});