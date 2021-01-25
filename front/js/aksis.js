$('body').on('click','#loginUrl', function (event) {
    event.preventDefault();
    var url = $(this).attr('data-action');
    window.location.href = url;
})

$('body').on('click','.formFile', function (event) {
    event.preventDefault();
    var url = $(this).attr('data-action');
    window.location.href = url;
})

$('body').on('click','.modalshows',function (event) {
    event.preventDefault();
    
    var url = $(this).attr('href');

    $.ajax({
        url : url,
        dataType : 'html',
        success : function (response) {
            $('#modal-body').html(response);
        }
    })

    $('#exampleModal').modal('show');
})

$('body').on('click','#modal-btn-save', function (event) {
    event.preventDefault();
    var form = $('#modal-body form'),
        url = form.attr('action'),
        method = form.attr('method')

        $.ajax({
            url : url,
            method : method,
            data : new FormData(form[0]),
            contentType : false,
            processData: false,
            datatype : 'JSON',
            success: function (response) {
                $('#exampleModal').modal('hide');
                swal("Bila Store", "Data Berhasil di Tambahkan", "success");
                $('#myTable').load();

            }
        })
       

})