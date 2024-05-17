<!DOCTYPE html>
<html>
<head>
	 <title>Integrating Responsive File Manager with Tinymce</title>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	 <script type="text/javascript" src="tinymce/js/tinymce/tinymce.min.js"></script>
	 <script type="text/javascript">
	 tinymce.init({
	 selector: "textarea",theme: "modern",width: 680,height: 300,
	 plugins: [
	 "advlist autolink link image lists charmap print preview hr anchor pagebreak",
	 "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
	 "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
	 ],
	 toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
	 toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor | print preview code ",
	 image_advtab: true , relative_urls: false,
	 
	 external_filemanager_path:"/lechinh_tinymce/ResponsiveFilemanager-master/filemanager/",
	 filemanager_title:"Responsive Filemanager" ,
	 external_plugins: { "filemanager" : "/lechinh_tinymce/ResponsiveFilemanager-master/filemanager/plugin.min.js"}
	 });
	 </script>
</head>
<body>
	<form>
	 <textarea></textarea>
	</form>
</body>
</html>