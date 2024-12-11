 <div class="container-fluid" id="subBodyContent">
     <div class="page-wrapper-img-inner">
         <div class="row">
             <div class="col-sm-12">
                 <div class="page-title-box" style="height: 90px;">

                     <h4 class="page-title mb-2"><i class="mdi dripicons-user-id"
                             style="margin-right: 5px;"></i><?php echo $titlePage ?></h4>
                     <div class="">
                         <ol class="breadcrumb">
                             <li class="breadcrumb-item"><a href="javascript:void(0);">Advice</a></li>
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
                             <table id="dataDoc" class="table table-bordered nowrap"
                                 style="border-collapse: collapse; border-spacing: 0;width: 100%;border-radius: 10px;">
                                 <thead>
                                     <tr>
                                         <th>action
                                         </th>
                                         <th>NIP</th>
                                         <th>Employee Name</th>
                                         <th>NIK</th>
                                         <th>Unit</th>
                                         <th>Whatsapp Number</th>
                                         <th>Email</th>

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

 <div class="modal fade bs-example-modal-lg" id="modalMyunit" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered">
         <div class="modal-content" style="border-radius: 5px;">
             <div class="modal-header" style="background-color: #e8e8e8;">
                 <h5 class="modal-title mt-0" id="myLargeModalLabel">My Unit</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
             </div>
             <div class="modal-body" id="mainMyunit">

             </div>
             <div class="modal-footer">

                 <div class="spinner" id="loaderMyUnit" style="display:none;margin-right: 10px;"></div>

                 <button type="button" onclick="updateMyunit()" id="buttonsaveMyUnit"
                     class="btn btn-round btn-success waves-effect waves-light">Update</button>


             </div>
         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div>


 <footer class="footer text-center text-sm-left">
     <span class="text-muted d-none d-sm-inline-block float-right">Develop with <i
             class="mdi mdi-heart text-danger"></i> by Dukungan Teknologi Informasi</span>
 </footer>

 <!-- select2 -->

 <script type="text/javascript">
function calldata() {

    $('#dataDoc').DataTable({
        scrollX: false,
        "processing": true,
        "serverSide": true,
        "order": false,
        "lengthMenu": [30, 60, 90, 120],
        "pageLength": 30,
        "ajax": {
            url: '<?php echo base_url('callDataEmpJson') ?>',
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

    $('#example').dataTable().fnDraw(false)

}

$(document).ready(function() {
    calldata();

})


function updateMyunit() {
    var form_data = new FormData($('#frmMyunit')[0]);

    $.ajax({
        url: "<?php echo base_url('updateMyunit') ?>",
        global: false,
        async: true,
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        enctype: "multipart/form-data",
        data: form_data,
        beforeSend: function() {
            $('#buttonsaveMyUnit').hide()

            $('#loaderMyUnit').show()
        },
        success: function(e) {
            if (e.status == 'ok;') {
                $('#buttonsave').show()
                $('#buttonclose').show()
                $('#loaderMyUnit').hide()
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



                $.each(e.dataname, function(key, value) {

                    document.getElementById(key + "-error").innerHTML = "";
                });
                $.each(e.data, function(key, value) {


                    document.getElementById(key + "-error").innerHTML =
                        `<span class="badge badge-danger" style="">` + value + `
                                        </span>`;
                });



                $('#buttonsaveMyUnit').show()

                $('#loaderMyUnit').hide()
            }
        },
        error: function(xhr, status, error) {
            $('#buttonsaveMyUnit').show()

            $('#loaderMyUnit').hide()
            alert(xhr.responseText);
        }

    });
}

function modaleMyunit(nip_emp) {

    $.ajax({
        url: "<?php echo base_url('modalMyunit') ?>",
        global: false,
        async: true,
        type: 'post',
        dataType: 'json',
        data: ({
            id: nip_emp,
        }),
        success: function(e) {
            if (e.status == 'ok;') {
                var option = ' <option value="">- Pilih Unit Anda -</option>';
                var unit_name = e.dataEmp['unit_emp']

                $.each(e.data, function(key, value) {
                    option +=
                        `<option value="${value['unit_name']}" ${value['unit_name']==unit_name?'selected':''}>${value['unit_name']}</option>`;
                })
                console.log(unit_name)
                var html = `
                             <form id="frmMyunit">

                              <div class="row form-material">
                             
                                 <input type="hidden" name="nip_emp" value=${e.dataEmp['nip_emp']}>
                                <div class="col-lg-12 mb-2">
                                  <label for="Myunit">Choose Unit</label>
                                            <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;"  id="Myunit" name="Myunit">
                                              ${option}
                                          </select>
                                          <div id="Myunit-error">
                                            
                                          </div>
                                          <div id="nip_emp-error">
                                            
                                          </div>
                                  </div>
                               
                            </div> 
                              
                            </form> 
                                `;
                $('#mainMyunit').html(html);
                $("#Myunit").select2({
                    dropdownParent: $("#modalMyunit"),
                })

                $("#modalMyunit").modal('show');
            }
        },
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        }

    });
}
 </script>