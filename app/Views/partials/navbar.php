<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Inventaris Sistem</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="An Arsip System for document in Telkom University Jakarta" name="description" />
    <meta content="Mannatthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('') ?>assets_login/images/logo_darsy_notext.png">

    <link href="<?php echo base_url('') ?>/assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="<?php echo base_url('') ?>/assets/plugins/morris/morris.css">


    <link href="<?php echo base_url('') ?>/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="<?php echo base_url('') ?>/assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <link href="<?php echo base_url('') ?>/assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />


    <!-- Responsive datatable examples -->
    <link href="<?php echo base_url('') ?>/assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- App css -->
    <link href="<?php echo base_url('') ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url('') ?>/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css"
        integrity="sha512-MQXduO8IQnJVq1qmySpN87QQkiR1bZHtorbJBD0tzy7/0U9+YIC93QWHeGTEoojMVHWWNkoCp8V6OzVSYrX0oQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="<?php echo base_url('') ?>/assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url('') ?>/assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('') ?>/assets/css/spiner.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="<?php echo base_url('') ?>/assets/extension/filepond/filepond.css">
    <link rel="stylesheet"
        href="<?php echo base_url('') ?>/assets/extension/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url('') ?>/assets/css/filepond.css"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/brands.min.css"
        integrity="sha512-9YHSK59/rjvhtDcY/b+4rdnl0V4LPDWdkKceBl8ZLF5TB6745ml1AfluEU6dFWqwDw9lPvnauxFgpKvJqp7jiQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css"
        integrity="sha512-SgaqKKxJDQ/tAUAAXzvxZz33rmn7leYDYfBP+YoMRSENhf3zJyx3SBASt/OfeQwBHA1nxMis7mM3EV/oYT6Fdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/solid.min.css"
        integrity="sha512-yDUXOUWwbHH4ggxueDnC5vJv4tmfySpVdIcN1LksGZi8W8EVZv4uKGrQc0pVf66zS7LDhFJM7Zdeow1sw1/8Jw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/regular.min.css"
        integrity="sha512-WidMaWaNmZqjk3gDE6KBFCoDpBz9stTsTZZTeocfq/eDNkLfpakEd7qR0bPejvy/x0iT0dvzIq4IirnBtVer5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Include Bootstrap Datepicker -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />



    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">
    <!-- <link rel=stylesheet href=https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css> -->

    <script src="https://unpkg.com/html5-qrcode"></script>

 


</head>

<body>

    <!-- Top Bar Start -->

    <div class="topbar" id="topbar" style="transition: top 0.3s ease-in-out;">
        <!-- Navbar -->
        <nav class="navbar-custom">

            <ul class="list-unstyled topbar-nav mb-0">

                <li>
                    <button class="button-menu-mobile nav-link waves-effect waves-light" style="color: #ffff;">
                        <i class="mdi mdi-menu nav-icon"></i>
                    </button>
                </li>


            </ul>
            <!-- LOGO -->
            <div class="topbar-left">

                <a href="index.html" class="logo">

                    <span>
                        <img src="<?php echo base_url('') ?>assets_login/images/logo_darsy_putih.png" alt="logo-large"
                            class="logo-lg">
                    </span>
                </a>

            </div>

            <ul class="list-unstyled topbar-nav float-right mb-0">

                <li class="dropdown">

                </li>

                <li class="dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">

                        <img src="<?php echo (session()->photo_url!=null?session()->photo_url :base_url('assets/images/img_profile.jpg')) ?>"
                            alt="profile-user" class="rounded-circle" style="object-fit: cover;" />
                        <span class="ml-1 nav-user-name hidden-sm"> <i class="mdi mdi-chevron-down"></i> </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" style="min-width: 225px;">

                        <a class="dropdown-item pointer" href="" download><i class="fa-solid fa-download text-muted mr-2"></i>
                            Download Manual Book</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url('logout') ?>">Logout</a>
                    </div>
                </li>
            </ul>


        </nav>
        <!-- end navbar-->
    </div>
    <div class="loader-top-container">
        <div class="loader-top"></div>
    </div>
    <!-- Top Bar End -->
    <div class="page-wrapper-img">

    </div>

    <div class="page-wrapper">
        <div class="page-wrapper-inner">
            <div class="page-content " id="body-content">
                <div class="row justify-content-center" id="loaderbody" style="display:none;">
                    <div class="spinnerbody" id="loader" style=";margin-top: 25%;"></div>
                </div>


            </div>
            <!-- end page content -->
            <!-- Left Sidenav -->
            <div class="left-sidenav" style="">

                <ul class="metismenu left-sidenav-menu mt-0" id="side-nav">
                    <div class="dropdown-nick mb-2">
                        <div style="" class="profileimage mb-2">
                            <img src="<?php  echo (session()->photo_url!=''?session()->photo_url :base_url('assets/images/img_profile.jpg')) ?>"
                                class="" style=" ;" />
                        </div>
                        <p style=""> <?php echo session()->name_emp ?></p>
                        <p style="">
                            <?php echo ucwords( strtolower( str_replace('PROGRAM STUDI','',str_replace('BAGIAN','',str_replace(' KAMPUS JAKARTA', '',  session()->unit_emp)))  ) ) ?>
                        </p>
                        <a class="role-toggle" id="show-role">
                            <p> <?php echo ucwords((session()->type)) ?> <i class="mdi mdi-chevron-down"></i> </p>

                        </a>

                    </div>
                    <div class="dropdown-role un-show" id="dataRole" style="">

                        <div class="data-role">
                            <?php 
                                    $i=0;
                                    foreach ($dataRole as $value) { ?>
                            <a class="role-item"
                                onclick="changeRole('<?php echo $value['id_role_tetap'] ?>', '<?php echo $value['type_role'] ?>')"><?php echo ucwords($value['type_role'])?>
                            </a>
                            <?php if (count($dataRole)!=($i+1)) {?>
                            <div class="dropdown-divider" style="border-color: rgb(220, 220, 220);"></div>
                            <?php } $i++; } ?>

                        </div>
                    </div>
                    <li class="menu-title">Menu Utama</li>

                    <li>
                        <a href="javascript: void(0)" onclick="showContent('/', event)" id='/'
                            class="pointer menu-clear"><i class="mdi mdi-monitor-dashboard"></i>Dashboards</a>
                    </li>
          
                     <li>
                        <a href="<?php echo base_url('DataEmployee'); ?>" onclick="showContent('DataEmployee', event)"
                            id='DataEmployee' class="pointer menu-clear"><i
                                class="mdi dripicons-user-id pointer"></i>Employee</a>
                    </li>
                    
                    <li>
                        <a href="javascript: void(0)" onclick="showContent('UserAdmin', event)"
                            id='UserAdmin' class="pointer menu-clear"><i
                                class="mdi mdi-account-multiple pointer"></i>User Management</a>
                    </li>
                                
                    <li>
                        <a href="javascript: void(0)" onclick="showContent('listInventaris', event)"
                            id='listInventaris' class="pointer menu-clear"><i
                                class="mdi mdi-archive pointer"></i>List Invetaris</a>
                    </li>
            
                    <li>
                        <a href="javascript: void(0)" onclick="showContent('loanCart', event)"
                            id='loanCart' class="pointer menu-clear"><i
                                class="mdi mdi-cart pointer"></i>Loan Cart</a>
                    </li>
   
                    <li>
                        <a href="javascript: void(0)" onclick="showContent('LoanProcess', event)"
                            id='LoanProcess' class="pointer menu-clear">
                            <i class="mdi  mdi-swap-horizontal-bold pointer"></i>Loan Process</a>
                    </li>
                    


                </ul>
            </div>

            <div class="modal fade bs-example-modal-lg" id="modalMyunit" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
            <!-- end left-sidenav-->


        </div>
    </div>

    <script>
    let prevScrollPos = window.pageYOffset;
    const topBar = document.getElementById('topbar');

    window.onscroll = function() {
        const currentScrollPos = window.pageYOffset;
    
        if (prevScrollPos >= currentScrollPos) {
            topBar.style.top = '0';
        } else {
            topBar.style.top = `-${topBar.offsetHeight}px`;
        }

        prevScrollPos = currentScrollPos; 
    };

    window.addEventListener('popstate', function(event) {

        location.reload();
    });
    $(document).ready(function() {
        showContent('<?php echo $_SERVER['REQUEST_URI'] ?>', event);

    })

    $('#show-role').on('click', function() {
        $('#dataRole').toggleClass('un-show')
    })

    function showContent(routes = '/', event) {
        event.preventDefault()
        window.history.pushState({
            someData: "optional data"
        }, "New Page Title", routes);
        if (routes == '/') {
            var id = routes
        } else {
            var id = routes.replace(/\//g, "")
        }


        var btn = document.getElementById(id);
        $.ajax({
            url: "<?php echo base_url('contentHome') ?>",
            global: false,
            async: true,
            type: 'post',
            dataType: 'json',
            data: ({
                routes: id,
            }),
            beforeSend: function() {
                $('.loader-top-container').show()
                document.querySelector('.loader-top').style.animationPlayState = 'running';
                $('#loaderbody').show()
                btn.removeAttribute("onclick");
                clearInterval();

            },
            success: function(e) {
                document.querySelector('.loader-top').style.animationPlayState = 'paused';

                $('.loader-top-container').hide()
                $('#loaderbody').hide()
                if (e.status == 'ok;') {

                    $(".left-sidenav a.pointer").each(function() {
                        var pageUrl = window.location.href.split(/[?#]/)[0];
                        var baseUrl = '<?php echo base_url(''); ?>'
                        // console.log(baseUrl+ this.id)
                        // console.log('==')
                        // console.log(pageUrl)
                        var subpath = this.id
                        if (this.id == '/') {
                            subpath = ''
                        }
                       var parentMenu = $(this).parent().parent().parent().parent().attr('id');
                       var subparentMenu = $(this).parent().parent().attr('id');
                       var clas_a = $(this).attr('class');
                       var cek_sub = clas_a.split(" ");
                    //    console.log(parentMenu!="ParentMenu"+cek_sub[1])
                    //    console.log("-----------")
                    //    console.log(baseUrl + subpath == pageUrl)
                    //    console.log(cek_sub[1])
                    console.log(subparentMenu)
                        if (baseUrl + subpath == pageUrl) {
                            $(this).addClass("active-menu");
                            $(this).parent().addClass("active-menu"); // add active to li of the current link
                            $(this).parent().parent().addClass("in");
                            $(this).parent().parent().prev().addClass("active-menu"); // add active class to an anchor
                            $(this).parent().parent().parent().addClass("active-menu active");
                            $(this).parent().parent().parent().parent().addClass("in"); // add active to li of the current link
                            $(this).parent().parent().parent().parent().parent().addClass("active-menu active");
                        } else {
                            $(this).removeClass("active-menu");
                            $(this).parent().removeClass("active-menu"); // add active to li of the current link
                            
                            if (parentMenu!='ParentMenu'+cek_sub[1]){
                                
                               
                                // if (cek_sub[1]!='sub' || cek_sub[1]!='Doc'){
                                    // $(this).parent().parent().removeClass("in");
                                // }
                                $(this).parent().parent().prev().removeClass("active-menu"); // add active class to an anchor
                                // $(this).parent().parent().parent().removeClass("active-menu");
                                $(this).parent().parent().parent().parent().removeClass("in"); // add active to li of the current link
                                $(this).parent().parent().parent().parent().parent().removeClass("active-menu");
                                
                            }else{
                                // $(this).parent().parent().parent().parent().parent().removeClass("active");
                                // $(this).parent().parent().addClass("in");
                                // $(this).parent().parent().parent().removeClass("active");
                                // $(this).parent().parent().removeClass("in");
                            }
                            
                        }
                    });

                    var lebarJendela = $(window).width();
                    if (lebarJendela <= 1024) {
                        $('body').addClass('enlarge-menu')
                    }
                    document.getElementById('body-content').innerHTML = ""
                    // location.reload();
                    $('#body-content').html(e.contentView)
                    // $('#subBodyContent').show()
                    btn.setAttribute("onclick", "showContent('" + id + "', event)");


                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }

        });
    }

    function changeRole(idRole, typeRole) {
        $.ajax({
            url: "<?php echo base_url('changeRole') ?>",
            global: false,
            async: true,
            type: 'post',
            dataType: 'json',
            data: ({
                idRole: idRole,
                typeRole: typeRole
            }),
            success: function(e) {
                if (e.status == 'ok;') {

                    location.reload();

                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }

        });
    }


    function download_userguide(session){
        window.location.href= session=='staff'?'assets/User _Guide _Advice_staff.pdf':'';
    }
    </script>
    <!-- end page-wrapper -->

    <?php echo view('partials/script_spa') ?>

</body>

</html>