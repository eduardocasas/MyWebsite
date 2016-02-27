$(document).ready(function(){
        
    var WRAPPER = $('#file_list_wrapper');

    /* ----------- Upload File ----------- */

    function displayUploadFile() {
        var date = new Date(),
            month = date.getMonth()+1,
            year = date.getFullYear();
        if (month < 10) {
            month = '0'+month;
        }
        $('[data-year='+year+']', WRAPPER).show('slow', function(){ $('[data-month='+month+']', WRAPPER).show('slow'); });
    }
    $(function () {
        $('#upload_file_button').after('<button class="upload_button">Subir</button>');
        $('.upload_button').click(function(event) {
            event.preventDefault();
            $(this).prev($('input[type=file]')).click();
        });
    });
    $('#upload_file_button').change(function(event) {
        var xhr = new XMLHttpRequest();
        var file = event.target.files[0];
        $('#inner_progress_bar').css('width', 0).fadeIn();
        $('#progress_bar').fadeIn();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                WRAPPER.html(xhr.response).hide().fadeIn('slow', function(){ displayUploadFile(); });
                $('#progress_bar').fadeOut();
            }
        };
        xhr.open('POST', FILE_UPLOAD_URL, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest"); // <-- añadido para symfony2
        xhr.setRequestHeader("X_FILENAME", file.name);
        xhr.addEventListener('progress', function(event) {
            if (event.lengthComputable) {
                $('#inner_progress_bar').css('width', (100*event.loaded / event.total)+'%');
            }
        });
        xhr.send(file);
    });

    /* ----------- Remove File ----------- */

    $('#remove').click(function() {
        var data = { 'file' : [] };
        $(":checked").each(function() {
            data.file.push($(this).val());
        });
        $.post(REMOVE_FILE_URL, { 'file[]' : data }, function() {
            $('#file_list_wrapper :checked').closest('li').fadeOut('slow', function(){ $(this).remove(); });
            $('#remove').fadeOut();                        
        });
    });

    /* ----------- Tree ----------- */

    WRAPPER.on('change', 'input', function() {
        if ($(this).prop('checked')) {
            $('#remove').fadeIn();
        } else if (!$(':checked', WRAPPER).length) {
            $('#remove').fadeOut();
        }
    });
    WRAPPER.on('click', '.folder', function() {
        if ($(this).hasClass('open_folder')) {
            $(this).removeClass('open_folder');
            $(this).next('ul').hide('slow');
        } else {
            $(this).addClass('open_folder');
            $(this).next('ul').show('slow');
        }

    });

});