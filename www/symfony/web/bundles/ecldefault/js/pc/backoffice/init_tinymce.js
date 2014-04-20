tinymce.init({
    selector : "#article_form_article_extend_content",
    menubar:false,
    statusbar: false,
    plugins: ["fullscreen image link textcolor"],
    toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | removeformat | bullist numlist | link image | fullscreen",
    image_advtab: true,
    setup : function(ed) { ed.on('init',function(){this.getDoc().body.style.fontSize = '0.85em';});}
});