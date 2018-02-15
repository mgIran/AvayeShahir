$(function () {
    $('.course-carousel').each(function () {
        var rtl = $(this).data('rtl');
        $(this).owlCarousel({
            rtl: rtl,
            navText: ['<span class=\"arrow\"></span>', '<span class=\"arrow\"></span>'],
            navClass: ['owl-prev disabled', 'owl-next'],
            callbacks: true,
            info: true,
            margin: 30,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                    margin: 15,
                    dots: true,
                    stagePadding: 15
                },
                459: {
                    items: 2,
                    nav: true,
                    margin: 10,
                    dots: false,
                    stagePadding: 0
                },
                1025: {
                    items: 2,
                    nav: true,
                    margin: 40,
                    dots: false,
                    stagePadding: 0
                },
                1201: {
                    items: 3,
                    nav: true,
                    margin: 10,
                    dots: false,
                    stagePadding: 0
                },
                1401: {
                    items: 3,
                    nav: true,
                    margin: 40,
                    dots: false,
                    stagePadding: 0
                },
                1601: {
                    items: 4,
                    nav: true,
                    margin: 10,
                    dots: false,
                    stagePadding: 0
                },
            },
            onTranslated: $(this).on('translated.owl.carousel', function (e) {
                var items_per_page = e.page.size;
                var nav_container = $('.course-carousel .owl-nav');
                var item_index = e.item.index;
                var item_count = e.item.count;
                var last_vis_item_index = items_per_page + item_index;
                if (last_vis_item_index === item_count) {
                    $(nav_container).find('div:last').addClass('disabled');
                }
                else {
                    $(nav_container).find('div:last').removeClass('disabled');
                }
                if (item_index != 0) {
                    $(nav_container).find('div:first').removeClass('disabled');
                }
                else {
                    $(nav_container).find('div:first').addClass('disabled');
                }
            })
        });
    });
});