$(document).ready(function () {
var $start = moment().subtract(6, 'days');
var $end = moment();
var $table = $('#datatable_with_daterange');
// console.log('hi');

 $.ajax({
        type: "get",
        url: "/invoices/ajax-filter-invoices",
        data: {data:'123'},
        // dataType: "json",
        success: function (response) {
            // console.log(response);
            // console.log(response.success);
            console.log(response.errors);
        },
        done: function(result){
            console.log(result.result);
       },
       error: function(error) {
            console.log(error);
       }
    });
// configure datatablewith serverSide false
// $table.DataTable(
//     {
//         'serverSide':false,
//         'ajax':
//         {
//             'url': '/invoices/ajax-filter-invoices'
//         },
//         "columns":[
//                         {data: 'date'},
//                         {data: 'invoice_no'},
//                         {data: 'customer_name'},
//                         {data: 'customer_phone'},
//                         {data: 'customer_address'},
//                         {data: 'total'},
//                         {data: 'note'},
//                         {data: 'id'}
//                     ],
//     }
// );

})

// // set data and call fetch data when load page
// cb($start, $end);

// // fill date in input or div place holder
// function cb($start, $end) {
//     $('#reportrange span').html($start.format('D/M/YYYY') + ' - ' + $end.format('D/M/YYYY'));

//     fetch_data($start.format('YYYY-MM-DD') ,$end.format('YYYY-MM-DD'));

// }

// $('#reportrange').daterangepicker({
//     startDate: $start,
//     endDate: $end,
//     dom: 'Bfrtip',
//         buttons: [
//             'copy', 'csv', 'excel', 'pdf', 'print'
//         ],
//     ranges: {
//         'Hôm nay': [moment(), moment()],
//         'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
//         '7 ngày gần nhất': [moment().subtract(6, 'days'), moment()],
//         '30 ngày gần nhất': [moment().subtract(29, 'days'), moment()],
//         'Tháng này': [moment().startOf('month'), moment().endOf('month')],
//         'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
//     }
// }, cb)
// .on('apply.daterangepicker', function(ev, picker) {
//     $startDate = picker.startDate.format('YYYY-MM-DD');
//     $endDate = picker.endDate.format('YYYY-MM-DD');

//     fetch_data($startDate ,$endDate);
//     //fdt_without_datatable($startDate ,$endDate);
// });
// function fetch_data(start_date = '', end_date = ''){
//     $table.DataTable().destroy();

//     // load data source for datatable

//     var $dataTable = $table.DataTable({
//         // "processing" : true,
//         // "serverSide" : true,
//         // "order": [2,'desc'],
//         "order": [],
//         dom: 'Bfrtip',
//         buttons: [
//             {
//                 extend: 'colvis',
//                 text: "Ẩn / Hiện cột"
//             },
//             {
//                 extend: 'excelHtml5',
//                 text: "Xuất excel",
//                 exportOptions: {
//                     columns: [ 0, 1, 2, 3, 4, 5 ,6 ]
//                 },
//                 customize: function( xlsx, row ) {
//                         var sheet = xlsx.xl.worksheets['sheet1.xml'];
//                         $('row c[r^="G"], row c[r^="F"]', sheet).attr( 's', 64);
//                 }
//             }

//         ],

//         // stateSave: true,
//         "ajax" : {
//             type: "GET",
//             url: "/invoices/ajax-filter-invoices",
//             data:{start_date:start_date, end_date:end_date},
//             dataSrc: 'data'
//         },
//         "columns":[
//             {data: 'date'},
//             {data: 'invoice_no'},
//             {data: 'customer_name'},
//             {data: 'customer_phone'},
//             {data: 'customer_address'},
//             {data: 'total'},
//             {data: 'note'},
//             {data: 'id'}
//         ],
//         "columnDefs":[
//             {
//                 "targets":[7],
//                 'searchable':false,
//                 "orderable":false,
//                 "width": "5%",
//                 'render': function(data){
//                     return `<a href="/admin/invoices/invoiceId/edit" class="btn btn-sm btn-link"><i class="far fa-edit"></i>&nbsp;&nbsp;Sửa</a>
//                     <button type="submit" class="btn btn-sm btn-link btn_invoice_delete" data-orderid="invoiceId" ><i class="far fa-trash-alt"></i>&nbsp;Xóa</button>
//                     <a target="_blank" href="/admin/invoices/invoiceId/print" class="btn btn-sm btn-success waves-effect waves-light"><i class="fa fa-print"></i>&nbsp;In</a>`
//                     .replace(/invoiceId/g,data);
//                 }
//             },
//             // {"targets":[2],
//             // "width": "10%"
//             // },
//             // {"targets":[4],
//             // "width": "20%"
//             // },
//             { "visible": false, "targets": [1,6] }
//         ]
//     });


//     // delete invoice
//     $table.on('click','.btn_invoice_delete', function(){
//         // event.preventDefault();
//         Swal.fire({
//             title: 'Bạn có chắc muốn?',
//             text: "Xóa xóa hóa đơn này không?",
//             icon: 'warning',
//             showCancelButton: true,
//             confirmButtonColor: '#3085d6',
//             cancelButtonColor: '#d33',
//             confirmButtonText: 'Vâng, xóa hóa đơn!'
//             }).then((result) => {
//             if (result.isConfirmed) {
//                 var $row = $dataTable.row($(this).parents('tr'));
//                 var $invoiceId = $(this).attr('data-orderid');
//                 deleteInvoice($invoiceId, $row)
//             }

//         })

//     });


//     function deleteInvoice($invoiceId, $row){
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });
//         $.ajax({
//             type: "DELETE",
//             url: "/invoices/ajax-delete",
//             data: {invoiceID:$invoiceId},
//             dataType: "json",
//             success: function (response) {
//                 if(response.message){
//                 $row.remove().draw(false);
//                 toastr.success(response.message);
//                 return true;
//                 };
//             }
//         });
//     };
//     // print invoice

//     $table.on('click','.btn_invoice_print', function(){
//         alert('hi');
//     });

// }



// });
