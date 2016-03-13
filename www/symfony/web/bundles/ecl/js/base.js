$(document).ready(function() {
    
    $('#display_sidebar_button').click(function() { $('#default_sidebar_wrapper, #nav').toggle(); });
    
    /* -------------- Hide/Show header when scrolling -------------- */
    
    var mobileView = $('#default_sidebar_wrapper').css('position') == 'fixed';
    $(window).on('resize', function(){
        mobileView = $('#default_sidebar_wrapper').css('position') == 'fixed';
        if (!mobileView) {
            headerWrapper.show();   
        }
    });
    var headerWrapper = $('#main_header_wrapper');
    var headerWrapperHeight = headerWrapper.height();
    var lastScrollTop = 0;

    $(window).scroll(function() {
        if (mobileView) {
            var st = $(this).scrollTop();
            if (st > lastScrollTop){
                if ($(document).scrollTop() < headerWrapperHeight) {
                    headerWrapper.slideDown();
                } else if ($('#default_sidebar_wrapper').css('display') == 'none') {
                    headerWrapper.hide();
                }
            } else {
              headerWrapper.slideDown();
            }
            lastScrollTop = st;        
        }
    });    
    

});