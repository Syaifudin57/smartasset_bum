$(document).ready(function () {
    $('.tombol-yakin').on('click', function (e) {
        e.preventDefault();
        const href = $(this).attr('href');
        const isidata = $(this).data('isidata') || 'Data ini akan dihapus!';

        swal({
            title: 'Yakin?',
            text: isidata,
            icon: 'warning',
            buttons: ['Batal', 'Ya, Hapus'],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                document.location.href = href;
            }
        });
    });
});
