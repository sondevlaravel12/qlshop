tinymce.init({
    selector: ".tiny_editor",
    theme: "modern",
    width: '100%',
    height: 400,
    plugins: [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime media nonbreaking save table contextmenu directionality',
        'emoticons template paste textcolor colorpicker textpattern imagetools'
    ],
    toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | responsivefilemanager | link unlink anchor | image media | forecolor backcolor | print preview code fontselect fontsizeselect charmap fullscreen hr",
    image_advtab: true , relative_urls: true, entity_encoding : "raw",

    external_filemanager_path:"/asset/editor/ResponsiveFilemanager-master/filemanager/",
    filemanager_title:"Responsive Filemanager" ,
    external_plugins: { "filemanager" : "/asset/editor/ResponsiveFilemanager-master/filemanager/plugin.min.js"}
});


//Multiple select
$('.multiple_select').chosen();
$("#select_catalog").on("change", function (e) {
    var items= $(this).val();
    $('input[name=select-catalog]').val(items);
})
$("#select_tag").on("change", function (e) {
    var items= $(this).val();
    $('input[name=select-tag]').val(items);
})

//Count word
$('#seo_title').simplyCountable({
    counter: '#counter2',
    countType: 'character',
    maxCount: 10,
    countDirection: 'up'
});

$('#seo_description').simplyCountable({
    counter: '#counter3',
    countType: 'character',
    maxCount: 10,
    countDirection: 'up'
});

$('#seo_keyword').simplyCountable({
    counter: '#counter4',
    countType: 'character',
    maxCount: 10,
    countDirection: 'up'
});