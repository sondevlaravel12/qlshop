init.push(function () {
	//Thêm hình offer
	last_offer = parseInt($('#last_offer').val());
    $('#add_new_offer').click(function(e){
		e.preventDefault();
		last_offer++;
		$.get(admin_url+'/common/get_offer',{id:last_offer},function(data){
			$('#product-tab-banner table tbody').append(data);
		});

    });
	
	//Thay đổi hidden value khi nhấn upload hình trong table
	$('#product-tab-banner').on('change','.upload_img',function(){
		var img_name = this.files[0].name;
		$(this).closest('tr').find('.hidden_img').val(img_name);		
	});
	
    // Setup validation
    $("#jq-validation-form").validate({
        ignore: '.ignore, .select2-input',
        focusInvalid: false,
        rules: {
            'article-name': {
                required: true,
            }		
        },
        messages: {
            'jq-validation-policy': 'You must check it!'
        }
    });	
	
});