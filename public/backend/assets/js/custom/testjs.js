$(".delete_invoice").submit(function( event ) {
    event.preventDefault();
    Swal.fire({
        title: 'Bạn có chắc muốn?',
        text: "Xóa hoa don này?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'vâng, xóa hoa don!'
        }).then((result) => {
        if (result.isConfirmed) {

            Swal.fire(
            'Xóa!',
            'Dữ liệu đã xóa.',
            'success'
            )
            $(".delete_invoice").off("submit").submit();
        }

    })
});
