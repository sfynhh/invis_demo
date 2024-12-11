<div class="container-fluid" id="subBodyContent">
                     <div class="page-wrapper-img-inner">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box" style="height: 90px;">

                                        <h4 class="page-title mb-2"><i class="mdi mdi-monitor-dashboard"></i> <?php echo $titlePage ?></h4>
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
                        <div class="row justify-content-right">
                            <div class="col-sm-4 mt-1 mb-4 ">
                             
                                    <input type="text" placeholder="Search..." class="form-control search-custom" id="search">
                                    
                                  
                                
                            </div>
                            <div class="col-sm-3 mt-1 mb-4 ">
                                <select class="select2 form-control mb-3 custom-select" style="width: 100%;background:transparent;border-radius:30px;"
                                name="asset_location" id="filterCampusLoc">
                                <option value="all">Location..</option>

                                <option value="Kampus A">Kampus A</option>
                                <option value="Kampus B">Kampus B</option>
                                <option value="Kampus C">Kampus C</option>

                            </select>
                            </div> 
                            <div class="col-sm-3 mt-1 mb-4 ">
                            <button class="btn btn-dark btn-round btn-md waves-effect waves-light" id="buttonCallModalQR" onclick="callModalQr()"><i class="fa-solid fa-qrcode" style="margin-right: 5px;"></i>Add Cart With QR</button>
                            </div>
                        </div>
                        <div class="row kontenproduk" id="kontenproduk">                        
 
                        </div>
                        <div class="row justify-content-center">
                                        <nav aria-label="Page navigation example" class="pagination-wrap" id="pagination-wrap">
                                 
                                        </nav>
                        </div>
</div>


<div class="modal fade bs-example-modal-md" id="enterlistLoan" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content" style="border-radius: 5px;">
            <div class="modal-header" style="background-color: #e8e8e8;">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Input Amount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="form-amount">
              
            </div>
            <div class="modal-footer">

                <div class="spinner" id="loaderDoc" style="display:none;margin-right: 10px;"></div>

                <button type="button" onclick="AddListLoan()" id="buttonsaveDoc" class="btn btn-round btn-success waves-effect waves-light">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade bs-example-modal-md" id="modalQr" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content" style="border-radius: 5px;">
            <div class="modal-header" style="background-color: #e8e8e8;">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Qr add to Cart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="form-amount">
              <div class="row justify-content-right">
                <div id="qr-reader" style="width:100%"></div>
              
              </div>
            </div>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<script>

$(document).ready(function() {

    // produk_pagination();
    showproduk("all")

})

              var source = document.getElementById('search');

              var inputHandler = function(e) {
                //showproduk(e.target.value);
                $.ajax({
                  url: "<?php echo base_url('assetShow') ?>",
                  global: false,
                  async: true,
                  type: 'post',
                  dataType: 'json',
                  data: ({
                    search: e.target.value
                  }),
                  success: function(e) {
                    var html = '';


                    $.each(e.data, function(key, value) {
                      // console.log(`ini${value.amount_asset}`)
                      if (value.amount_asset > 0) {
                        var label = 'bg-label-success';
                        var disabled = '';
                      } else {
                        var label = 'bg-label-danger';
                        var disabled = 'disabled';
                      }
                      html +=`
                             <div class="col-lg-3 subkonten" id="subkonten">
                                <div class="card e-co-product">
                                    <a href="">  
                                        <img src="<?php echo base_url('') ?>/assets/img/asset/${value.asset_image}" alt="" class="img-fluid">
                                    </a>                                    
                                    <div class="card-body text-center product-info">
                                        <a href="" class="product-title">${value.asset_name}</a>
                                        <a href="#" class="product-title">(${value.asset_location})</a>
                                        <p class="product-price"> Available :${value.amount_asset}<span class="ml-2"></span></p>
                                        <button class="btn btn-dark btn-round btn-sm waves-effect waves-light"  onclick="modalEnterAmount('${value.id_asset}', ${value.amount_asset})" `+disabled+`><i class="mdi mdi-cart mr-1"></i> Add To Loan Cart</button>
                                       
                                    </div><!--end card-body-->
                                </div><!--end card-->
                            </div><!--end col-->
                          `
                    });

                    $('#kontenproduk').html(html);
                    $('#pagination-wrap').html('');
                    produk_pagination();


                  },
                  error: function(xhr, status, error) {
                    alert(xhr.responseText);
                  }

                })
              }

              source.addEventListener('input', inputHandler);
              source.addEventListener('propertychange', inputHandler);

              $('#filterCampusLoc').on('change', function (){
                showproduk($(this).val());
              })


function showproduk(search) {
                $.ajax({
                  url: "<?php echo base_url('assetShow') ?>",
                  global: false,
                  async: true,
                  type: 'post',
                  dataType: 'json',
                  data: ({
                    search: search
                  }),
                  beforeSend: function() {
                   
                    },  
                  success: function(e) {
                    var html = '';


                    $.each(e.data, function(key, value) {
                      // console.log(`ini${value.amount_asset}`)
                      if (value.amount_asset - value.loan_cart_amount > 0) {
                        var label = 'bg-label-success';
                        var disabled = '';
                      } else {
                        var label = 'bg-label-danger';
                        var disabled = 'disabled';
                      }
                 

                          html +=`
                             <div class="col-lg-3 subkonten" id="subkonten">
                                <div class="card e-co-product">
                                    <a href="#">  
                                        <img src="<?php echo base_url('') ?>/assets/img/asset/${value.asset_image}" alt="" class="img-fluid">
                                    </a>                                    
                                    <div class="card-body text-center product-info">
                                        <a href="#" class="product-title">${value.asset_name}</a>
                                        <a href="#" class="product-title">(${value.asset_location})</a>
                                        <p class="product-price"> Available :${value.amount_asset - value.loan_cart_amount }<span class="ml-2"></span></p>
                                        <button class="btn btn-dark btn-round btn-sm waves-effect waves-light" onclick="modalEnterAmount('${value.id_asset}', ${value.amount_asset})" `+disabled+`><i class="mdi mdi-cart mr-1"></i> Add To Loan Cart</button>
                                       
                                    </div><!--end card-body-->
                                </div><!--end card-->
                            </div><!--end col-->
                          `
                    });

                    $('#kontenproduk').html('');
                    $('#kontenproduk').html(html);
                    $('#pagination-wrap').html('');
                    produk_pagination();

                  },
                  error: function(xhr, status, error) {
                    alert(xhr.responseText);
                  }

                })

              }

    function modalEnterAmount(id_asset, max) {
   

      var html =`
                 <form id="frmtambah">
                            <div class="row g-4">
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="nip">Input Amount</label>
                                        <div class="form-control-wrap">
                                            <input type="hidden" name="id_asset" class="form-control" value="${id_asset}"">
                                            <input type="number" name="amount" class="form-control" value="1" max="${max}" min="1" required">
                                        </div>
                                        <div id="id_asset-error">

                                        </div>
                                        <div id="amount-error">

                                        </div>
                                    </div>
                                </div>
                                

                            </div>
                         
                          
                        </form> 
      `
                //document.getElementById('#form-amount').innerHTML='';
           
                  $('#form-amount').html(html);
                  $('#enterlistLoan').modal('show');
               
    }

    function AddListLoan() {
                //var form_data = new FormData($('#frmtambah')[0]);
                $.ajax({
                  url: "<?php echo base_url('addLoanCart') ?>",
                  global: false,
                  async: true,
                  type: 'post',
                  dataType: 'json',
                  data: $('#frmtambah').serialize(),
                  success: function(e) {
                    if (e.status == 'ok;') {

                      $("#enterlistLoan").modal('hide');
                      let timerInterval
                      Swal.fire({
                        icon: 'success',
                        title: 'data has been added',
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
                          $('#kontenproduk').html("");
                          $('#pagination-wrap').html("");
                          showproduk("all")
                        }
                      })

                    } else {
                      $.each(e.dataname, function(key, value) {
                        document.getElementById(key + "-error").innerHTML = "";
                      });
                      $.each(e.data, function(key, value) {

                        document.getElementById(key + "-error").innerHTML = `<span class="badge bg-label-danger">` + value + `</span>`;
                      });

                      $("#enterlistLoan").modal('show');
                    }
                  },
                  error: function(xhr, status, error) {
                    alert(xhr.responseText);
                  }
                })
              }
    
    function produk_pagination() {
                $(function() {
                  var numberOfitem = $('.kontenproduk .subkonten ').length;
                  var limitPerpage = 16;
                  var totalPages = Math.ceil(numberOfitem / limitPerpage);
                  var paginationSize = 5;
                  var currentPage;

                  function showPage(whichPage) {
                    if (whichPage < 1 || whichPage > totalPages) return false;

                    currentPage = whichPage;

                    $('.kontenproduk .subkonten ').hide().slice((currentPage - 1) * limitPerpage, currentPage * limitPerpage).show();
                    $('.pagination-wrap li').slice(1, -1).remove();

                    // var halaman=1;
                    // var cek=getPageList(totalPages, currentPage, paginationSize);
                    // console.log(cek);
                    getPageList(totalPages, currentPage, paginationSize).forEach(item => {

                      $("<li>").addClass("page-item").addClass(item ? "current-page" : "dots").toggleClass("active", item === currentPage).append($("<a>").addClass("page-link")
                        .attr({
                          href: "javascript:void(0)"
                        }).text(item || "...")).insertBefore(".next");

                    });

                    $(".prev").toggleClass("disabled", currentPage === 1);
                    $(".next").toggleClass("disabled", currentPage === totalPages);
                    return true;
                  }
                  //console.log(numberOfitem); 

                  $(".pagination-wrap").append(
                    $("<ul>").addClass("pagination custom-pagination-2").append(
                      $("<li>").addClass("page-item").addClass("prev").append($("<a>").attr({
                        href: "javascript:void(0)"
                      }).addClass("page-link").append("Prev")),
                      
                      $("<li>").addClass("page-item").addClass("next").append($("<a>").attr({
                        href: "javascript:void(0)"
                      }).addClass("page-link").append("Next"))
                    ))

                  $(".kontenproduk").show();
                  showPage(1);
                  $(document).on("click", ".pagination-wrap li.current-page:not(.active)", function() {
                    return showPage(+$(this).text());
                  });

                  $(".next").on("click", function() {
                    return showPage(currentPage + 1);
                  });

                  $(".prev").on("click", function() {
                    return showPage(currentPage - 1);
                  });
                });
              }

   function getPageList(totalPages, page, maxLength) {
                function range(start, end) {
                  return Array.from(Array(end - start + 1), (_, i) => i + start);
                }

                var sideWidth = maxLength < 9 ? 1 : 2;
                var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
                var rightWidth = (maxLength - sideWidth * 2 - 3) >> 1;
                // console.log(sideWidth);

                if (totalPages <= maxLength) {
                  return range(1, totalPages);
                }

                if (page <= maxLength - sideWidth - 1 - rightWidth) {
                  return range(1, maxLength - sideWidth - 1).concat(0, range(totalPages - sideWidth + 1, totalPages));
                }

                if (page >= totalPages - sideWidth - 1 - rightWidth) {
                  return range(1, sideWidth).concat(0, range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages));
                }

                return range(1, sideWidth).concat(0, range(page - leftWidth, page + rightWidth), 0, range(totalPages - sideWidth + 1, totalPages));
              }

function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete"
            || document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

function callModalQr(){
  docReady(function () {
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;
        function onScanSuccess(decodedText, decodedResult) {
          console.log(lastResult)
          console.log(decodedText)
              if (decodedText !== lastResult) {
                  ++countResults;
                  lastResult = decodedText;
                  // Handle on success condition with the decoded message.
                  // alert(`Scan result ${decodedText}`);
                  addCartFromQr(decodedText, html5QrcodeScanner)
              
            }
        }
        
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox:  { width: 250, height: 250 } });
        html5QrcodeScanner.render(onScanSuccess);
 
        $('#html5-qrcode-button-camera-permission').addClass('btn btn-dark btn-round btn-md waves-effect waves-light')
        
        $('#html5-qrcode-button-camera-permission').click()
          
        document.getElementById("qr-reader__scan_region").style.transform = "scaleX(-1)";
         
  $('#modalQr').modal('show')

});
}


      $('#modalQr').on('hidden.bs.modal', function (e) {
      
         
          // console.log($("#html5-qrcode-button-camera-stop").length)
          // $('#html5-qrcode-button-camera-stop').click()
          if ($("#html5-qrcode-button-camera-stop").length) {
             console.log("hai")
            $('#html5-qrcode-button-camera-stop').click()
          } 
           
        });


function addCartFromQr(urlAdd, QRcode){
  $.ajax({
                    url: urlAdd,
                    global: false,
                    async: true,
                    type: 'post',
                    dataType: 'json',
                    
                    success: function(e) {
                      if (e.status == 'ok;') {

                     
                        var timerInterval
                        Swal.fire({
                          icon: 'success',
                          title: 'data has been added',
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
                            $('#kontenproduk').html("");
                            $('#pagination-wrap').html("");
                             showproduk("all")
                            //  $('#modalQr').modal('hide')
                            // QRcode.html5Qrcode.stop()
                            //  callModalQr()
                             
                          }
                        })

                      } else {
                        //action when stock is 0
                        var timerInterval
                        Swal.fire({
                          icon: 'error',
                          title: 'Data cannot added',
                          text:'Inventaris stock is Unavailable',
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
                            // $('#modalQr').modal('hide')
                            // QRcode.html5Qrcode.stop()
                            //  callModalQr()
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