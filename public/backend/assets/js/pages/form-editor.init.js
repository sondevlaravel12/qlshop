var description_config = {
    path_absolute : "/",
    selector: 'textarea.myeditorinstance',
    setup: function(editor) {
        editor.on('keyup', function(e) {
        var wordcount = tinymce.activeEditor.plugins.wordcount;
        var $characterCount = wordcount.body.getCharacterCount();
        descriptionCharCountLive($characterCount);
        });
    },
    height:500,

    entity_encoding : "raw",

    relative_urls: false,
    remove_script_host: false,
    convert_urls: true,
    document_base_url: "http://hatgionggiare.test/",

// document_base_url : "/",


    plugins: [
      "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
      "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
      "insertdatetime media nonbreaking save table directionality",
      "emoticons template paste textpattern",
      "save table contextmenu directionality emoticons template paste textcolor"
    ],
    toolbar:" insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
    file_picker_callback : function(callback, value, meta) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = description_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
      if (meta.filetype == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.openUrl({
        url : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no",
        onMessage: (api, message) => {
          callback(message.content);
        }
      });
    },
    formats: {
        bold: { inline: 'b' },
        italic: { inline: 'i' }
      },
    extended_valid_elements: 'b[*],i[*],span[*]',
    image_dimensions: false,
         image_class_list: [
            {title: 'Responsive', value: 'img-responsive'}
        ]
  };

  tinymce.init(description_config);


  var short_description_config = {
    path_absolute : "/",
    selector: 'textarea.shorttext',
    height: 250,
};

tinymce.init(short_description_config);

function characterCount(num){
    $spanToShow = $('#description-char-count');
    $spanToShow.val(num);
}


