$(function() {
    $.ajaxSetup({
        data: {
            'YII_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        document.onkeypress = document.onkeydown = document.onkeyup = fn;
        // disable right click
        $(document).bind('contextmenu', function (e) {
            return false;
        });
        // Disable cut copy paste
        $(document).bind('cut copy paste select', function (e) {
            return false;
        });

        $(".ajax-load").each(function () {
            var el = $(this);
            $.ajax({
                url: baseUrl + "/load",
                data: {hash: $(".ajax-load").data("hash")},
                dataType: 'json',
                type: "POST",
                beforeSend: function () {
                    el.find(".loading-container").show();
                },
                success: function (data) {
                    el.find(".loading-container").hide();
                    if (data.status) {
                        el.find(".context").html(data.content);
                    } else
                        alert(data.message);
                }
            });
        });
    });

    $("body *").not(".auto-select").css('user-select', 'none').on('selectstart', false);


    var fn = function (e) {
        if (!e)
            var e = window.event;
        var keycode = e.keyCode;
        if (e.which)
            keycode = e.which;

        var src = e.srcElement;
        if (e.target)
            src = e.target;

        if (e.ctrlKey || (keycode >= 112 && keycode <= 123)) {
            console.log("disable copy :)!");
            // Firefox and other non IE browsers
            if (e.preventDefault) {
                e.preventDefault();
                e.stopPropagation();
            }
            // Internet Explorer
            else if (e.keyCode) {
                e.keyCode = 0;
                e.returnValue = false;
                e.cancelBubble = true;
            }
            return false;
        }
    };
});