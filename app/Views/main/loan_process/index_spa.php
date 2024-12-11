<div class="container-fluid" id="subBodyContent">
    <div class="page-wrapper-img-inner">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box" style="height: 90px;">

                    <h4 class="page-title mb-2"><i class="mdi mdi-archive pointer"
                            style="margin-right: 5px;"></i><?php echo $titlePage ?></h4>
                    <div class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Inventaris System</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $titlePage ?></a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-body ">
                    <div class="button-items mb-2">

                      

                    </div>
                    <div class="table-rep-plugin ">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="dataDoc" class="table table-bordered nowrap"
                                style="border-collapse: collapse; border-spacing: 0;width: 100%;border-radius: 10px;">
                                <thead>
                                    <tr>

                                    <th>Action</th>
                                    <th>ID Loan</th>
                                    <th>Nama Peminjam</th>
                                    <th>Unit/Prodi</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Barang</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row --> 
</div><!-- container -->


<footer class="footer text-center text-sm-left">
    <span class="text-muted d-none d-sm-inline-block float-right">Develop with <i class="mdi mdi-heart text-danger"></i>
        by Dukungan Teknologi Informasi</span>
</footer>

<script>
    function calldata() {

    $('#dataDoc').DataTable({
        scrollX: false,
        "processing": true,
        "serverSide": true,
        "order": false,
        "lengthMenu": [30, 60, 90, 120],
        "pageLength": 30,
        "ajax": {
            url: '<?php echo base_url('callLoanProcess') ?>',
            type: "POST",
            // success : function(e) {
            //         // $('#loader_front').hide()
            //         // $('#loader_container').hide()
            // },
            // data : function(data){
            //     // data.periode =document.getElementById('bulan').value;
            // }

        },
        "columnDefs": [{
            "targets": '_all',
            "orderable": false,
            // render: $.fn.dataTable.render.html()
        }],
        "language": {
            "processing": "<div class=\"spinner\"  style=\"margin-left: 40%;\"></div>",
        }
    });


}

function reloadtable() {

    $('#dataDoc').dataTable().fnDraw(false)

}



$(document).ready(function() {
    calldata();

    $("#selectType").select2({
            dropdownParent: $("#modaltambah")
        })
    $("#selectType1").select2({
            dropdownParent: $("#modaltambah")
        })
    $("#selectType2").select2({
            dropdownParent: $("#modaltambah")
        })


        $.ajax({
                url: "<?php echo base_url('generate_id_asset') ?>",
                global: false,
                async: true,
                type: 'post',
                dataType: 'json',
                success: function(e) {
                    if (e.status == 'ok;') {
                        $('#asset_id').val(e.newId)
                    }
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }

            });
            
    FilePond.registerPlugin(FilePondPluginFileValidateType);
    FilePond.registerPlugin(FilePondPluginImagePreview);
    FilePond.registerPlugin(FilePondPluginFileValidateSize);

    const fileUP = FilePond.create(document.querySelector(".image-preview-filepond"), {
        credits: null,
        allowImagePreview: true,
        allowImageFilter: false,
        allowImageExifOrientation: false,
        required: true,
        allowImageCrop: false,
        name: 'file_doc',
        storeAsFile: true,
        labelIdle: 'Upload Document (image), Max File Size 4 MB',
        acceptedFileTypes: ['image/png'],
        fileValidateTypeDetectType: (source, type) =>
            new Promise((resolve, reject) => {
                // Do custom type detection here and return with promise
                resolve(type);
            }),
    });

    fileUP.setOptions({
        maxFileSize: '4MB'
    });

})


function endedLoan(id) {
    Swal.fire({
        title: 'Yakin Ingin mengakhiri loan ?',
        text: "Loan tidak akan bisa direset",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, end it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo base_url('endedLoan') ?>",
                global: false,
                async: true,
                type: 'post',
                dataType: 'json',
                data: ({
                    id: id,
                }),
                success: function(e) {
                    if (e.status == 'ok;') {

                        let timerInterval
                        Swal.fire({
                            icon: 'success',
                            title: ' Loan has been ended',
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true,
                            didOpen: () => {
                                timerInterval = setInterval(() => {

                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                $('#dataDoc').dataTable().fnDraw(false)
                            }
                        })

                    }
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }

            });


        }
    })
}


</script>