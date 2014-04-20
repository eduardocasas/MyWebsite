$(document).ready
(
        
    function()
    {
        $('#article_form_title').keyup
        (
            function()
            {
                $('#article_form_slug').val($('#article_form_title').val().toLowerCase().replace(/ /g, '-').replace(/ñ/g, 'n'));
            }
        );
    }
            
);