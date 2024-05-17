//Validate phần thông tin chính sản phẩm
init.push(function () {
    $('#nestable3').nestable({
    	maxDepth:2
    }).on('change', updateOutput);
    
    function updateOutput(){
    	var output = window.JSON.stringify($('.dd').nestable('serialize'));
    	var url = admin_url + 'campaign/sortable_campaign';
    	$.post(url,{data:output},function(){
    		// console.log('update success');
    	});
    }
    
    $("#jq-validation-form").validate({
        ignore: '.ignore, .select2-input',
        focusInvalid: false,
        rules: {
            'camp_title': {
                required: true,
            },
            'camp_link': {
                required: true,
            }
        },
        messages: {
            'jq-validation-policy': 'You must check it!'
        }
    });
});    
