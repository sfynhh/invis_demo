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
                
                    <div class="table-rep-plugin ">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                   
                                                        <th>Quantity</th>                                                        
                                                     
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodyTableCart">
                                                    
                                                 
                                                </tbody>
                                            </table>
                        </div>

                    </div>
                    <div class="button-items mb-2 row justify-content-center mt-2">

                        <button type="button" id="buttonShowForm" class="btn btn-dark btn-round btn-sm waves-effect waves-light" onclick="formProsesLoan()">Process Loan</button>

                    </div>
                       
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row --> 
</div><!-- container -->

<div class="modal fade bs-example-modal-lg" id="modalLoanProcess" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background-color: #e8e8e8;">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Loan Process</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="mainProcess">

            </div>
            <div class="modal-footer">
                <div class="spinner" id="loaderProcess" style="display:none;margin-right: 10px;"></div>
                <button type="button" id="buttoncloseProcess" class="btn btn-round btn-secondary waves-effect"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="addLoanProcess()" id="buttonsaveProcess"
                    class="btn btn-round btn-success waves-effect waves-light">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    function calldata(){
        $.ajax({
            url: "<?php echo base_url('callDataCarts') ?>",
            global: false,
            async: true,
            type: 'get',
            dataType: 'json',
      
            success: function(e) {
                if (e.status == 'ok;') {


                    var html = ``;
                    // console.log(e.data.length)
                    if(e.data.length==0){
                        $("#buttonShowForm").attr("disabled", true)
                    }
                    $.each(e.data, function(key, value) {

                        html +=`    
                                <tr>
                                       <td>
                                            <img src="<?php echo base_url('') ?>assets/img/asset/${value['asset_image']}" alt="" height="52">
                                             <p class="d-inline-block align-middle mb-0">
                                                 <a href="" class="d-inline-block align-middle mb-0 product-name">${value['asset_name']}</a> 
                                                 <br>
                                                 <span class="text-muted font-13">${value['asset_type']}</span> 
                                             </p>
                                     </td>
                                     <td>
                                        <input class="form-control w-25" type="number" value="${value['jumlah_unit']}" name="loanQty" id="${value['id_asset']}" max="${value['amount_asset']}">
                                        <div id="errorQty${value['id_asset']}">

                                        </div>
                                         
                                     </td>
                                        <td>
                                     <button onclick="deletedata(${value.id_list_loan})" class="btn btn-outline-danger  btn-xs"><i class="mdi mdi-close-circle-outline font-20"></i></button>
                                    </td>
                              </tr>
                        `
                    });
                  
                    $('#bodyTableCart').html(html);
                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }

        });
    }
    $(document).ready(function() {
        calldata();
        })

    function formProsesLoan(){
        var dataCartform=``;
        var cekError=false;
        $('input[name="loanQty"]').each(function(){
            if (parseInt($(this).val()) <= parseInt($(this).attr("max"))){
                $("#errorQty"+$(this).attr('id')).html("")
                dataCartform+=`<input class="form-control w-25" type="hidden" value="${$(this).attr("id")}|${$(this).val()}" name="detailCart[]">`
              
            }else{
                cekError=true;
                $("#errorQty"+$(this).attr('id')).html("")
                var eror=`<span class="badge badge-danger"> Quantity melebihi stock </span>`;
                $("#errorQty"+$(this).attr('id')).html(eror)

            }
           
        })

        if(!cekError){
            var formProcess=` <form id="frmprocess">
                                    ${dataCartform}
                                     <div class="form-group">
                                        <label for="selectProcess">Chosee PIC</label>
                                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="pic" id="selectProcess">
                                            <option value="">-- pilih PIC --</option>
                                        </select>
                                          <div id="pic-error">

                                         </div>
                                         <div id="detailCart-error">

                                         </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputUnit">Unit Name</label>
                                        <input type="text" name="unit" id="inputUnit" class="form-control" placeholder="Masukan Unit" readonly>
                                         <div id="unit-error">

                                         </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputContact">Contact</label>
                                        <input type="text" name="contact" id="inputContact" class="form-control" placeholder="Masukan No telfon" readonly>
                                         <div id="contact-error">

                                         </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputDuration">Loan Duration</label>
                                        <input type="text" name="loanDuration" id="inputDuration" class="form-control" placeholder="Masukan durasi peminjaman" style="background-color:white">
                                         <div id="loanDuration-error">

                                         </div>
                                    </div>
                                    
                                </form> `

            $("#mainProcess").html(formProcess)

            flatpickr('#inputDuration', {
                        minDate:'<?php echo date('Y-m-d', strtotime(date('Y-m-d') . ' + 1 days')) ?>',
                        mode: 'range',
                        static:true,
                        enableTime: false,
                        time_24hr:false,
                        dateFormat: "d M Y",
                    })


            $("#selectProcess").select2({
                dropdownParent: $("#modalLoanProcess"),
                ajax: {
                    url: "getNipNim",
                    dataType: 'json',
                    type: 'POST',
                    data: function(params) {
                        return {
                            searchTerm: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                },
                minimumInputLength: 3,

            }).on('select2:open', function(e) {
                $('.select2-search__field').attr('placeholder', 'Search Name');
            });

            $('#selectProcess').on('change', function() {
            //        
              var dataPic =$(this).val().split("|")  
              console.log(dataPic[2])
              if (dataPic[1]==''){
                $("#inputUnit").removeAttr("readonly");
              }else{
                $("#inputUnit").attr("readonly", true);
              }

              if (dataPic[2]==''){
                $("#inputContact").removeAttr("readonly");
              }else{
                $("#inputContact").attr("readonly", true);
              }

              $("#inputUnit").val(dataPic[1]);
              $("#inputContact").val(dataPic[2])
                                        
             });           


            $("#modalLoanProcess").modal("show")

        }
    }

    function addLoanProcess(){
        var form_data = new FormData($('#frmprocess')[0]);
        $.ajax({
            url: "<?php echo base_url('addLoanProcess') ?>",
            global: false,
            async: true,
            type: 'post',
            processData: false,
            contentType: false,
            dataType: 'json',
            enctype: "multipart/form-data",
            data: form_data,
            beforeSend: function() {
                $('#buttonsaveProcess').hide()
                $('#buttoncloseProcess').hide()
                $('#loaderProcess').show()
            },
            success: function(e) {
                if (e.status == 'ok;') {
                    $('#buttonsaveProcess').show()
                    $('#buttoncloseProcess').show()
                    $('#loaderProcess').hide()
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


                            document.getElementById(key + "-error").innerHTML = `<span class="badge badge-danger" style="">` + value + `</span>`;
                        });
                        // document.getElementById("signature_m-error").innerHTML ="";
                    } else {
                        document.getElementById("file-error").innerHTML =
                            `<span class="badge badge-danger" style="">` + e.text + `
                                                                                                </span>`;
                    }

                    $('#buttonsaveProcess').show()
                    $('#buttoncloseProcess').show()
                    $('#loaderProcess').hide()
                    $("#modaltambah").modal('show');
                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }

        });
    }
    
    function deletedata(id) {
    Swal.fire({
        title: 'Yakin Ingin menghapus data ?',
        text: "Data tidak akan bisa kembali",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo base_url('loanCartDelete') ?>",
                global: false,
                async: true,
                type: 'post',
                dataType: 'json',
                data: ({
                    id_list: id,
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
                                location.reload();
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