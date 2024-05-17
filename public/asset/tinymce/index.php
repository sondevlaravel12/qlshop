<script type="text/javascript" src="./js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	entity_encoding : "raw",
	relative_urls: false,
	external_filemanager_path:"./plugins/filemanager/",
	filemanager_title:"Quản lý file upload" ,
	external_plugins: { "filemanager" : "./plugins/filemanager/plugin.min.js"},
	height: 350		
});
</script>

<form method="post" action="somepage">
    <textarea name="content" style="width:100%"></textarea>
</form>