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

                        <button type="button" class="btn btn-dark btn-round btn-sm waves-effect waves-light"
                            data-toggle="modal" data-animation="bounce" data-target="#modaltambah"><i
                                class="fa-solid fa-plus" style="margin-right: 10px;"></i>Insert Data Inventaris</button>

                    </div>
                    <div class="table-rep-plugin ">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="dataDoc" class="table table-bordered nowrap"
                                style="border-collapse: collapse; border-spacing: 0;width: 100%;border-radius: 10px;">
                                <thead>
                                    <tr>

                                        <th>ID</th>
                                        <th>Asset Name</th>
                                        <th>Asset Type</th>
                                        <th>Asset Location</th>
                                        <th>Asset Amount</th>
                                       
                                     <th> Qr Code</th>
                                     <th>Asset Status</th>
                                        <th>Action</th>
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

<div class="modal fade bs-example-modal-lg" id="modaltambah" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background-color: #e8e8e8;">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Tambah data inventaris</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="frmtambah">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Id Inventaris</label>
                        <input type="text" id="asset_id" name="asset_id" class="form-control" value="" placeholder=""
                            readonly>
                        <div id="asset_id-error">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Inventaris Name</label>
                        <input type="text" name="asset_name" class="form-control" value=""
                            placeholder="Masukan Nama Inventaris">
                        <div id="asset_name-error">
                            <!-- <span class="badge badge-danger badge-pill" >eror</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selectType">Inventaris Type</label>
                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;"
                            name="asset_type" id="selectType">
                            <option value="">- Choose type -</option>

                            <option value="electronic">Electronic</option>
                            <option value="nonelectronic">Non-electronic</option>

                        </select>
                        <div id="asset_type-error">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selectType2">Inventaris Location</label>
                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;"
                            name="asset_location" id="selectType2">
                            <option value="">- Choose type -</option>

                            <option value="Kampus A">Kampus A</option>
                            <option value="Kampus B">Kampus B</option>
                            <option value="Kampus C">Kampus C</option>

                        </select>
                        <div id="asset_location-error">

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="selectType1">Inventaris Status</label>
                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;"
                            name="asset_status" id="selectType1">
                            <option value="">- Choose type -</option>

                            <option value="to loan">To loan</option>
                            <option value="maintenance">Maintenance</option>

                        </select>
                        <div id="asset_status-error">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Inventaris Amount</label>
                        <input type="number" name="amount" class="form-control" value=""
                            placeholder="Masukan Stock inventaris">
                        <div id="amount-error">
                            <!-- <span class="badge badge-danger badge-pill" >eror</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Image</label>
                        <input type="file" class="image-preview-filepond" value=""
                            placeholder="Masukan Deskripsi Document">
                        <div id="file-error">

                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <div class="spinner" id="loader" style="display:none;margin-right: 10px;"></div>
                <button type="button" id="buttonclose" class="btn btn-round btn-secondary waves-effect"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="addInventris()" id="buttonsave"
                    class="btn btn-round btn-success waves-effect waves-light">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade bs-example-modal-lg" id="modaledit" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background-color: #e8e8e8;">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Ubah data inventaris</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="mainedit">

            </div>
            <div class="modal-footer">
                <div class="spinner" id="loaderEdit" style="display:none;margin-right: 10px;"></div>
                <button type="button" id="buttoncloseEdit" class="btn btn-round btn-secondary waves-effect"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="updateInventaris()" id="buttonsaveEdit"
                    class="btn btn-round btn-success waves-effect waves-light">Update</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
            url: '<?php echo base_url('callListAsset') ?>',
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

function ShowImage(imageUrl) {
    // Buka URL gambar di tab baru
    window.open(imageUrl, '_blank');

    var link = document.createElement('a');
    link.href = imageUrl;
    link.download = imageUrl.split('/').pop(); // Nama file diambil dari URL
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
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


function addInventris() {
    var form_data = new FormData($('#frmtambah')[0]);
    $.ajax({
        url: "<?php echo base_url('addInventaris') ?>",
        global: false,
        async: true,
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        enctype: "multipart/form-data",
        data: form_data,
        beforeSend: function() {
            $('#buttonsave').hide()
            $('#buttonclose').hide()
            $('#loader').show()
        },
        success: function(e) {
            if (e.status == 'ok;') {
                $('#buttonsave').show()
                $('#buttonclose').show()
                $('#loader').hide()
                let timerInterval
                Swal.fire({
                    icon: 'success',
                    title: ' Data has been Saved',
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
                        location.reload();
                    }
                })

            } else {
                // $('#buttonsave').show()
                //  $('#buttonclose').Show()
                //  $('#loader').hide()
                if (e.text === '') {
                    $.each(e.dataname, function(key, value) {
                        document.getElementById(key + "-error").innerHTML = "";
                    });
                    $.each(e.data, function(key, value) {


                        document.getElementById(key + "-error").innerHTML =
                            `<span class="badge badge-danger" style="">` + value + `
                                                                                            </span>`;
                    });
                    // document.getElementById("signature_m-error").innerHTML ="";
                } else {
                    document.getElementById("file-error").innerHTML =
                        `<span class="badge badge-danger" style="">` + e.text + `
                                                                                            </span>`;
                }

                $('#buttonsave').show()
                $('#buttonclose').show()
                $('#loader').hide()
                $("#modaltambah").modal('show');
            }
        },
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        }

    });
}

function deletedata(id, image) {
    Swal.fire({
        title: 'Yakin Ingin menghapus data ?',
        text: "Data tidak akan bisa kembali",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo base_url('inventarisDelete') ?>",
                global: false,
                async: true,
                type: 'post',
                dataType: 'json',
                data: ({
                    id_docs: id,
                    img: image
                }),
                success: function(e) {
                    if (e.status == 'ok;') {

                        let timerInterval
                        Swal.fire({
                            icon: 'success',
                            title: ' Data has been Deleted',
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

function popupedit(id) {

$.ajax({
    url: "<?php echo base_url('modalEditInventaris') ?>",
    global: false,
    async: true,
    type: 'post',
    dataType: 'json',
    data: ({
        id: id,
    }),
    success: function(e) {
        if (e.status == 'ok;') {

            var option = '';
            var option2 = '';
            var option3 = '';

            option = `
                    <option value="electronic" ${e.data['asset_type']=='electronic'?'selected':''}>Electronic</option>
                    <option value="nonelectronic" ${e.data['asset_type']=='nonelectronic'?'selected':''}>Non-electronic</option>
                       
                `;

                option2 = `
                    <option value="to loan" ${e.data['asset_status']=='to loan'?'selected':''} >To loan</option>
                    <option value="maintenance" ${e.data['asset_status']=='maintenance'?'selected':''}>Maintenance</option>  
                `;
                option3 = `
                    <option value="Kampus A" ${e.data['asset_location']=='Kampus A'?'selected':''} >Kampus A</option>
                    <option value="Kampus B" ${e.data['asset_location']=='Kampsu B'?'selected':''}>Kampus B</option>  
                    <option value="Kampus C" ${e.data['asset_location']=='Kampus'?'selected':''}>Kampus C</option>  
                `;

            var html = `    <form id="frmedit">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">No Documents</label>
                                       
                                        <input type="text" name="asset_id" id="asset_id_edit" class="form-control" value="${e.data['id_asset']}" placeholder="Masukan Nomor Document" readonly>
                                        <div id="asset_id-error-edit">
                                            <!-- <span class="badge badge-danger badge-pill" >eror</span> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Inventaris Name</label>
                                        <input type="text" name="asset_name" class="form-control" value="${e.data['asset_name']}" placeholder="Masukan Deskripsi Document">
                                        <div id="asset_name-error-edit">
                                            <!-- <span class="badge badge-danger badge-pill" >eror</span> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="selectTypeEdit">Inventaris Type</label>
                                       <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="asset_type" id="selectTypeEdit">
                                         ${option}
                                        
                                        </select>
                                        <div id="asset_type-error-edit">
                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="selectType3Edit">Inventaris Location</label>
                                       <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="asset_location" id="selectType3Edit">
                                         ${option3}
                                        
                                        </select>
                                        <div id="asset_location-error-edit">
                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="selectTypeEdit1">Inventaris Status</label>
                                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="asset_status" id="selectTypeEdit1">
                                            ${option2}
                                            
                                            </select>
                                            <div id="asset_status-error-edit">
                             
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Inventaris Amount</label>
                                        <input type="text" name="amount" class="form-control" value="${e.data['amount_asset']}" placeholder="Masukan Deskripsi Document">
                                        <div id="amount-error-edit">
                                            <!-- <span class="badge badge-danger badge-pill" >eror</span> -->
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="exampleFormControlInput1">Image</label>
                                        <input type="hidden" name="old_doc" value="${e.data['asset_image']}">
                                        <input type="file" class="image-preview-filepond-edit" value="" placeholder="Masukan Deskripsi Document">
                                        <div id="old_doc-error-edit">
                                            <!-- <span class="badge badge-danger badge-pill" >eror</span> -->
                                        </div>
                                        <div id="file-error-edit">
                                            <!-- <span class="badge badge-danger badge-pill" >eror</span> -->
                                        </div>
                                    </div>
                                   
                                    
                                </form> 
                    `;
            $('#mainedit').html(html);

            $("#selectTypeEdit").select2({
                dropdownParent: $("#modaledit"),
                minimumResultsForSearch: -1
            });
            $("#selectTypeEdit1").select2({
                dropdownParent: $("#modaledit"),
                minimumResultsForSearch: -1
            });
            $("#selectType3Edit").select2({
                dropdownParent: $("#modaledit"),
                minimumResultsForSearch: -1
            });

            const base_url = '<?php echo base_url('') ?>'
            imgeasset = base_url + 'assets/img/asset/' + e.data['asset_image']


             console.log(e.imagesize)

            //var docroot =
            var file_doc = e.data['asset_image']
            var size = e.imagesize


            signaturepath = [{
                source: imgeasset,
                options: {
                    type: 'local',
                    file: {
                        name: file_doc,
                        size: size
                    }
                }
            }]


            // console.log(signaturepath)


            FilePond.registerPlugin(FilePondPluginFileValidateType);
            FilePond.registerPlugin(FilePondPluginImagePreview);
            FilePond.registerPlugin(FilePondPluginFileValidateSize);
            FilePond.create(document.querySelector(".image-preview-filepond-edit"), {
                credits: null,
                allowImagePreview: true,
                allowMultiple: false,
                allowFileEncode: false,
                required: true,
                // allowRemove:false,
                name: 'file_doc',
                storeAsFile: true,
                labelIdle: 'Upload Document (PDF)',
                acceptedFileTypes: ["image/png"],
                fileValidateTypeDetectType: (source, type) =>
                    new Promise((resolve, reject) => {
                        // Do custom type detection here and return with promise
                        resolve(type);
                    }),
                files: signaturepath,
                server: {
                    load: (source, load, error, progress, abort, headers) => {

                        error('oh my goodness');


                        progress(true, 0, 1024);
                        var file = '<?php echo base_url('assets/img/asset/')  ?>';

                        load(file);

                        return {
                            abort: () => {

                                abort();
                            },
                        };
                    },
                },

            });



            $("#modaledit").modal('show');
        }
    },
    error: function(xhr, status, error) {
        alert(xhr.responseText);
    }

});
}

function updateInventaris(){
    var form_data = new FormData($('#frmedit')[0]);

    $.ajax({
        url: "<?php echo base_url('prosesInventarisUpdate') ?>",
        global: false,
        async: true,
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        enctype: "multipart/form-data",
        data: form_data,
        beforeSend: function() {
            $('#buttoncloseEdit').hide()
            $('#buttonsaveEdit').hide()
            $('#loaderEdit').show()
        },
        success: function(e) {
            if (e.status == 'ok;') {
                $('#buttonsaveEdit').show()
                $('#buttoncloseEdit').show()
                $('#loaderEdit').hide()
                let timerInterval
                Swal.fire({
                    icon: 'success',
                    title: ' Data has been Updated',
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

                        location.reload();
                    }
                })
            } else {
                if (e.text === '') {
                    var msgeror = '';
                    $.each(e.dataname, function(key, value) {
                        document.getElementById(key + "-error-edit").innerHTML = "";
                    });

                    $.each(e.data, function(key, value) {
                        document.getElementById(key + "-error-edit").innerHTML =
                            `<span class="badge badge-danger">` + value + `
                                                                    </span>`;
                    });
                } else {
                    document.getElementById("file-error-edit").innerHTML =
                        `<span class="badge badge-danger" style="">` + e.text + `</span>`;
                }
                $('#buttonsaveEdit').show()
                $('#buttoncloseEdit').show()
                $('#loaderEdit').hide()
                $("#modaledit").modal('show');
            }
        },
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        }

    });
}


function createQR(id){
    $.ajax({
        url: "<?php echo base_url('createQrCode') ?>",
                global: false,
                async: true,
                type: 'post',
                dataType: 'json',
                data: ({
                    id_inventaris: id,
                  
                }),
                success: function(e) {
                    if (e.status == 'ok;') {

                        let timerInterval
                        Swal.fire({
                            icon: 'success',
                            title: ' QR has been Created',
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

    })
}


</script>