$.extend( $.fn.dataTable.defaults, {
    language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
    "order": [0,'desc'],
    drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
} );
// $.fn.dataTable.ext.order.intl('fr');
$.fn.dataTable.ext.order.intl('vn');
