var $body = $("body");
var $window = $(window);
$(function() {
    $.material.init();
    // course categories show trigger
    var $courseHover;
    $body.on('click','.course .three-dots-container',function () {
        $('.course .three-dots-container').not($(this)).parent().removeClass('open');
        $(this).parent().toggleClass('open');
    });
    $body.on('click','.course .course-pic',function () {
        $('.course .course-pic').not($(this)).parent().removeClass('open');
        $(this).parent().toggleClass('open');
    });
    $body.on('mouseleave','.course',function () {
        $(this).removeClass('open');
    });
//
    $('.scrollbar').each(function () {
        var $this = $(this),
            $align = (typeof $this.data('railalign') !== "undefined"?$this.data('railalign'):'right'),
            $offset = $align == 'right'?-5:5;
        $this.niceScroll({
            railalign:$align,
            railoffset:{left:$offset},
            cursorwidth:'4px',
            cursorborder:'none',
            zindex:10,
            autohidemode:false
        });
    });
    // fade out alert messages
    setInterval(function(){
        $(".alert:not(.message)").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 10000);

    $body.on("click" ,".scroll-link[href^='#']",function(e) {
        e.preventDefault();
        if($(window).width() < 768)
        {
            // $('.navTrigger').removeClass("clicked").find('.lines').removeClass("close");
            $("html,body").removeClass("overflow");
        }
        var href = $(this).attr('href');
        if(href.substr(1,href.length))
            $('html, body').animate({
                scrollTop: ($(href).offset().top-70)
            },1000,'easeOutCubic');
    });

    $("[data-toggle='tooltip']").tooltip({
        trigger:'hover'
    });
    $(".category [data-toggle='tooltip']").tooltip({
        trigger:'hover',
        template : '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner large"></div></div>'
    });

    $(".auto-select").focus(function () {
        $(this).select();
    }).click(function () {
        $(this).select();
    });
    
    $body.on('change','.navTrigger [type="checkbox"]',function() {
        if ($(".navTrigger").hasClass("clicked"))
            $(".navTrigger").removeClass("clicked");
        else
            $(".navTrigger").addClass("clicked");

        if ($("html,body").hasClass("overflow"))
            $("html,body").removeClass("overflow");
        else
            $("html,body").addClass("overflow");
    });

    var $affix = $('.affix-top');
    $affix.width($affix.parents('[class*="col-"]').width());
    $window.resize(function () {
        var $affix = $('.affix-top');
        $affix.width($affix.parents('[class*="col-"]').width());

        // resize course category boxes
        $('.courses .course').each(function () {
            setCourseCatHeight($(this));
        });
    });

    $('.courses .course').each(function () {
        setCourseCatHeight($(this));
    });
});

function setCourseCatHeight($this) {
    var $ch = $this.height(),
        $catE = $this.find('.course-cat-list'),
        $cath = $catE.height();
    if($ch-50 <= $cath)
        $catE.css({bottom:50});
}


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