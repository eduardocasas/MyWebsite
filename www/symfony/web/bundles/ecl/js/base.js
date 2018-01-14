$(document).ready(function() {
    
    /* -------------- Switch Language -------------- */
    
    $('#language').change(function() {
        window.location.href = $(':selected', $(this)).data('url');
    });
    
    /* ---------------- Responsive Design ---------------- */
    
    var isMobileView = $('#sidebar').css('display') == 'none';
    var header = $('#header');
    var footer = $('#footer');
    var mobileSidebar = $('#nav');
    var mobileSidebarIsVisible = false;
    function isScrolledIntoView() {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();
        var elemTop = footer.offset().top;
        var elemBottom = elemTop + footer.height();
        return (elemBottom <= docViewBottom) && (elemTop >= docViewTop);
    }        
    function setMobileSidebarSettings() {
        mobileSidebar.css('max-height', $(window).height()-header.height());
    }
    if (isMobileView) {
        setMobileSidebarSettings();
    }
    $('#display_sidebar_button').click(function() { 
        if (mobileSidebarIsVisible) {
            mobileSidebar.animate({ marginLeft: '-='+(mobileSidebar.width()+1)+'px' });
            $('#disable_background_on_sidebar').animate({ opacity: '-=0.5' }).promise().done(function () {
                $('#disable_background_on_sidebar').hide();
            });                        
            mobileSidebarIsVisible = false;
        } else {
            $('#disable_background_on_sidebar').show();
            mobileSidebar.animate({ marginLeft: '+='+(mobileSidebar.width()+1)+'px' });   
            $('#disable_background_on_sidebar').animate({ opacity: '+=0.5' });
            mobileSidebarIsVisible = true;
        }
        
    });
    $(window).on('resize', function() {
        isMobileView = $('#sidebar').css('display') == 'none';
        if (!isMobileView) {
            header.show();   
        } else {
            setMobileSidebarSettings();
        }
    });    
    
    /* -------------- Hide/Show header when scrolling -------------- */
    
    var lastScrollTop = 0;
    $(window).scroll(function() {
        if (isMobileView) {
            var st = $(this).scrollTop();
            if (st > lastScrollTop){
                if ($(document).scrollTop() < header.height()) {
                    header.slideDown();
                } else if (!mobileSidebarIsVisible) {
                    header.hide();
                }
            } else {
              header.slideDown();
            }
            lastScrollTop = st;        
        }
    });    
    

});