$(function() {
    "use strict"; 

    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    // scroll body to 0px on click
    $('#back-to-top').on('click', function(e) {
        $('#back-to-top').tooltip('hide');
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    
    $('#back-to-top').tooltip('show');

    var header = $(".listing_page");
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 100 && $(this).width() > 769) {
            header.addClass("navbar-fixed-top");
        } else {
            header.removeClass('navbar-fixed-top');
        }
    }); 

    var $searchlink = $('#searchlink');

    $searchlink.on('click', function(e){
        var target = e ? e.target : window.event.srcElement;

        if($(target).attr('id') == 'searchlink') {
            if($(this).hasClass('open')) {
              $(this).removeClass('open');
            } else {
              $(this).addClass('open');
            }
        }
    });


    // -------------------------------------------------------------
    //  Owl Carousel Slider ONE
    // -------------------------------------------------------------

    $("#slider_one").owlCarousel({
        items:4,
        margin:20,
        nav:false,
        autoplay:false,
       
        autoplayHoverPause:true,
     
        loop:true,
        navText: [
         "<i class='fa fa-arrow-circle-left'></i>",
          "<i class='fa fa-arrow-circle-right'></i>"
        ],
        responsive: {
            0: {
                items: 1,
                slideBy:1
            },
            480: {
                items: 1,
                slideBy:1
            },
            991: {
                items: 2,
                slideBy:2,
                loop:true,
                 dots:true,
            },
            1000: {
                items: 2,
                slideBy:2,
                loop:true,
            },
        }            

    });
        
    // -------------------------------------------------------------
    //  Owl Carousel Categories listing
    // -------------------------------------------------------------

        
     var owl = $('.listing');
    owl.owlCarousel({
        items: 1,
        loop:true,
        dots: false,
        margin: 10,
        rtl: false,
        autoplay:true,
//        slideTransition: 'linear',
        autoplayTimeout: 5000,
//        autoplaySpeed: 3000,
        autoplayHoverPause: false,
        nav:true,
        navText: [
           "<i class='fa fa-angle-left'></i>",
          "<i class='fa fa-angle-right'></i>"
        ],
        responsive: {
            0: {
                items: 1,
                autoplay:false,
            },
            500: {
                items: 1,
                slideBy:1,
                autoplay:false,
            },
            991: {
                items: 1,
                slideBy:1,
                loop:true,
                autoplay:false,
            },
            1200: {
                items: 1,
                slideBy:1,
                loop:true,
                
            },
        }    

    });
    
   
});