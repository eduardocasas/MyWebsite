$(document).ready(function(){function i(){e.css("max-height",$(window).height()-a.height())}$("#language").change(function(){window.location.href=$(":selected",$(this)).data("url")});var n="none"==$("#sidebar").css("display"),a=$("#header"),e=($("#footer"),$("#nav")),o=!1;n&&i(),$("#display_sidebar_button").click(function(){o?(e.animate({marginLeft:"-="+(e.width()+1)+"px"}),$("#disable_background_on_sidebar").animate({opacity:"-=0.5"}).promise().done(function(){$("#disable_background_on_sidebar").hide()}),o=!1):($("#disable_background_on_sidebar").show(),e.animate({marginLeft:"+="+(e.width()+1)+"px"}),$("#disable_background_on_sidebar").animate({opacity:"+=0.5"}),o=!0)}),$(window).on("resize",function(){n="none"==$("#sidebar").css("display"),n?i():a.show()});var d=0;$(window).scroll(function(){if(n){var i=$(this).scrollTop();i>d?$(document).scrollTop()<a.height()?a.slideDown():o||a.hide():a.slideDown(),d=i}})});