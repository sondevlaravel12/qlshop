$(document).ready(function () {
	data_url = admin_url + 'category/data';
	update_url = admin_url + 'category/update';
	insert_url = admin_url + 'category/insert';
	delete_url = admin_url + 'category/delete';
	
    // prepare the data
    var data = {};
    var theme = 'classic';
    var generaterow = function (id) {
        var row = {};
        row["id"] = 'new id';
        row["title"] = 'new title'
        row["name"] = 'new name';
        row["parent_id"] = 'new parent idS';
        return row;
    }
    var source =
    {
        datatype: "json",
        cache: false,
        datafields: [
			 { name: 'id' },
			 { name: 'title' },
			 { name: 'name' },
			 { name: 'parent_id' },
        ],
        id: 'EmployeeID',
        url: data_url,
        addrow: function (rowid, rowdata, position, commit) {
            // synchronize with the server - send insert command
            var data = "insert=true&" + $.param(rowdata);
            $.ajax({
                dataType: 'json',
                url: insert_url,
                data: data,
                cache: false,
                success: function (data, status, xhr) {
                    // insert command is executed.
                    commit(true);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    commit(false);
                }
            });
        },
        deleterow: function (rowid, rowdata, commit) {
            // synchronize with the server - send delete command
            var data = "delete=true&" + $.param(rowdata);
            $.ajax({
                dataType: 'json',
                url: delete_url,
                cache: false,
                data: data,
                success: function (data, status, xhr) {
                    // delete command is executed.
                    commit(true);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    commit(false);
                }
            });
        },
        updaterow: function (rowid, rowdata, commit) {
            // synchronize with the server - send update command
            var data = "update=true&" + $.param(rowdata);
            $.ajax({
                dataType: 'json',
                url: update_url,
                cache: false,
                data: data,
                success: function (data, status, xhr) {
                    // update command is executed.
                    commit(true);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    commit(false);
                }
            });
        }
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    // initialize jqxGrid
    $("#jqxgrid").jqxGrid(
    {
        width: 800,
        height: 350,
        source: dataAdapter,
        theme: theme,
		editable: true,
        enabletooltips: true,
        selectionmode: 'multiplecellsadvanced',
        columns: [
              { text: 'id', datafield: 'id', width: 50 },
              { text: 'Tên danh mục', datafield: 'title', width: 300 },
              { text: 'Url seo', datafield: 'name', width: 300 },
              { text: 'parent id', datafield: 'parent_id', width: 100 },
          ]
    });
    $("#addrowbutton").jqxButton({ theme: theme });
    $("#deleterowbutton").jqxButton({ theme: theme });
    $("#updaterowbutton").jqxButton({ theme: theme });
    // update row.
    $("#updaterowbutton").bind('click', function () {
        var datarow = generaterow();
        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
        if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
            var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
            $("#jqxgrid").jqxGrid('updaterow', id, datarow);
        }
    });
    // create new row.
    $("#addrowbutton").bind('click', function () {
        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
        var datarow = generaterow(rowscount + 1);
        $("#jqxgrid").jqxGrid('addrow', null, datarow);
    });
    // delete row.
    $("#deleterowbutton").bind('click', function () {
    	var datarow = generaterow();
        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
        // $("#jqxgrid").jqxGrid('deleterow', id, datarow);
        if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
            var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
            $("#jqxgrid").jqxGrid('deleterow', id);
        }
    });
});