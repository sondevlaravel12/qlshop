init.push(function () {
    var updateOutput = function (e)
    {
        var list = e.length ? e : $(e.target),
                output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

    $('#nestable3').nestable({
        group: 1
    })
            .on('change', updateOutput);
    updateOutput($('#nestable3').data('output', $('#output')));

    //Collase all
    $('.dd').nestable('collapseAll');
    //Expand menu
    var count = 0;
    $('#menu-expand').click(function () {
        if (count % 2 == 0) {
            $('.dd').nestable('expandAll');
        }
        else {
            $('.dd').nestable('collapseAll');
        }
        count++;
    })

    //Delete menu
    $('.menu_delete').click(function () {
        var confirm_delete = confirm('Bạn có muốn xóa menu này không?');
        if (confirm_delete == false) {
            return false;
        }
    });

    //Add new menu
    $('#them-moi-menu').click(function () {
        window.location.href = base_url + 'menu/them-moi-menu';
    });

    //Update sortable menu
    $('#menu_update').click(function () {
        var output = $('#output').val();
        if (output == '')
            return FALSE;

        $('#menu_sort_success').hide();
        $.ajax({
            url: base_url + 'menu/ajax_update_menu',
            dataType: "json",
            type: 'POST',
            data: {"menu": output},
            success: function (result) {
                if (result.status == 'ok') {
                    $('#menu_sort_success').slideDown();
                }
            }
        });
    });

    $('#clear-cache').click(function () {
        $.ajax({
            url: base_url + 'service/receive/?control=cache&func=clear_route',
            dataType: "json",
            type: 'GET',
            success: function (result) {
                if (result.code == '105') {
                    $('#clear_cache_desc').html(result.message);
                    $('#menu_clear_cache_success').slideDown();
                }
            }
        });
    })
});