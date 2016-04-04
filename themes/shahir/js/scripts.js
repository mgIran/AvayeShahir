$(function() {

    $('body').on('click', '.add-multipliable-input', function(){
        var input=document.createElement('input');
        input.type='text';
        input.name='Apps[permissions]['+$('.multipliable-input').length+']';
        input.placeholder='دسترسی';
        input.className='form-control multipliable-input';
        var container=document.getElementsByClassName('multipliable-input-container');
        $(container).append(input);
        return false;
    });

    $('body').on('click', '.remove-multipliable-input', function(){
        if($('.multipliable-input').length>1)
            $('.multipliable-input-container .multipliable-input:last').remove();
        return false;
    });

    if($(".app-description").height()>230)
        $(".app-description").next().show();
    $('body').on('click', '.more-text', function(){
        var $h = $(".app-description").height();
        if($(this).parent().hasClass('open'))
        {
            $(this).parent().animate({height:230},0).removeClass('open');
            $(this).find('span').html('توضیحات بیشتر');
        }
        else if($h>230)
        {
            $(this).parent().animate({height:$h+80},0).addClass('open');
            $(this).find('span').html('بستن');
        }
        return false;
    });

    $("body").on("click" ,"[href^='#']",function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        if(href.substr(1,href.length))
            $('html, body').animate({
                scrollTop: ($(href).offset().top)
            },1000);
    });

    $(window).scroll(function(){
        if($(this).scrollTop() > 100)
            $("header").css({'background-color':' rgba(3,24,45, 0.6)'});
        else
            $("header").css({'background-color':'rgba(0,0,0,0)'});
    });
});