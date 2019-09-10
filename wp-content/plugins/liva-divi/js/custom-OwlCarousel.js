jQuery(document).ready(function($) {
    $( window ).load(function() { 
        $('.highlight .owl-carousel').owlCarousel({
                        loop:true,
                        margin:30,
                        nav:true,
                        padding:0,
                        autoHeight:true,
                        responsive:{
                            0:{
                                items:1,
                                stagePadding: 60,
                            },
                            500:{
                                items:2,
                                stagePadding: 100,
                            },
                            768:{
                                items:2
                            },
                            1024:{
                                items:4
                            }
                        }
                    });

        $(".owl-carousel").each(function() {
            var that = $(this);
            var options = that.data('options');
                options = options == '' ? {} : options;
            that.owlCarousel(options);
        });
    });
});