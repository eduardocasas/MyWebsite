$(document).ready(function() {
        
    /* ----- Header ----- */

    var headerWrapper = $('#main_header_wrapper');
    var headerWrapperHeight = headerWrapper.height();
    var lastScrollTop = 0;

    $(window).scroll(function() {
        var st = $(this).scrollTop();
        if (st > lastScrollTop){
            if ($(document).scrollTop() < headerWrapperHeight) {
                headerWrapper.slideDown();
            } else {
                headerWrapper.hide();
            }
        } else {
          headerWrapper.slideDown();
        }
        lastScrollTop = st;        
    });
    $('#display_sidebar_button').click(function() { $('#default_sidebar_wrapper, #nav').toggle(); });

});