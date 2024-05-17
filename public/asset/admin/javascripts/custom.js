init.push(function () {
	//Xóa hình sản phẩm
	$('.profile-content').on('click','.delete_image',function(e){
        e.preventDefault();
        var id = $(this).parents('tr').attr('id');

        //Lưu vào mảng delete
        var list_delete = $('#list_delete').val();
		
		//Parse lại delete_id thành id
		raw_id = id.split('_');
		raw_id = raw_id[1];
        if( !list_delete ){
            list_delete = raw_id;
        }else{
            list_delete = list_delete + ',' + raw_id;
        }
        $('#list_delete').val(list_delete);

        //Xóa dòng
        $('#'+id).remove();	
	});

	//Confirm trước khi xóa
	$('.delete').click(function(){
		return confirm("Bạn có chắc chắn muốn xóa");
	});    

});

function convert_khong_dau(str){
    new_str = slugify(str);
    return new_str.replace(/dj/g,'d')
}

init.push(function () {
 if (! $('html').hasClass('ie8')) {
	 $(".summernote").summernote({
		 height: 300,
		 tabsize: 2,
		 codemirror: {
			 theme: 'monokai'
		 }
	 });
 }
});

//TinyMCE Editor
if( $('.tiny_editor').length > 0 ){
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
}



