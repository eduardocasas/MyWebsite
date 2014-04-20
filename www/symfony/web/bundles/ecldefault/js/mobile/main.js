$(document).ready
(
    function()
    {
        
        /* ----- Header ----- */

        var main_header            = $('#main_header_wrapper'),
            scroll_top_button      = $('#scroll_top_button'),
            display_sidebar_button = $('#display_sidebar_button'),
            sidebar                = $('#default_sidebar_wrapper'),
            display_sidebar        = false;
    
        main_header.hover
        (
            function()
            {
                main_header.removeClass('onscroll');
            },
            function()
            {
                if ($(document).scrollTop() != 0) {
                    main_header.addClass('onscroll');
                }
            }
        );
        $(window).scroll
        (
            function()
            {
                main_header.add(scroll_top_button).addClass('onscroll');
                if ($(document).scrollTop() == 0) {
                    main_header.add(scroll_top_button).removeClass('onscroll');
                }
            }
        );
        scroll_top_button.click
        (
            function(event)
            {
                event.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 600);
            }
        );
        display_sidebar_button.click
        (
            function()
            {
                var position;
                if (display_sidebar) {
                    display_sidebar = false;
                    position = -parseInt(sidebar.css('width'));
                } else {
                    display_sidebar = true;
                    position = 0;
                }
                sidebar.animate
                (
                    { left : position },
                    500
                );
            }
        );
    }
);