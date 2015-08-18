$(document).ready(function() {
        
    /* ----- Header ----- */

    var headerWrapper = $('#headerWrapper_wrapper');

    headerWrapper.hover(
        function() { headerWrapper.removeClass('onscroll') },
        function() {
            if ($(document).scrollTop() != 0) {
                headerWrapper.addClass('onscroll');
            }
        }
    );
    $(window).scroll(function() {
        headerWrapper.addClass('onscroll');
        if ($(document).scrollTop() == 0) {
            headerWrapper.removeClass('onscroll');
        }
    });
    $('#display_sidebar_button').click(function() { $('#default_sidebar_wrapper').toggle() });

});