<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="./././">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="An Arsip System for document in Telkom University Jakarta">
    <!-- Fav Icon  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="shortcut icon" href="<?php echo base_url('') ?>assets_login/images/logo_invis.png">
    <!-- Page Title  -->
    <title>Inventaris System</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo base_url('') ?>/assets_login/css/dashlite.css?ver=3.2.0">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url('') ?>/assets_login/css/theme.css?ver=3.2.0">
    <link id="skin-theme" rel="stylesheet"
        href="<?php echo base_url('') ?>/assets_login/css/skins/theme-red.css?ver=3.2.0">

    <style>
    .bg-login {
        background-image: url("<?php echo base_url('') ?>/assets_login/images/bg/bg_demo.webp");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        /*            position: relative;*/
    }

    .cs-box-shadow {
        box-shadow: -2px 1px 9px 7px rgba(0, 0, 0, 0.1);
        border-radius: 10px;

    }

    .logo-mobile-login {
        display: none;
    }

    @media (max-width: 1253px) {
        .logo-mobile-login {
            display: block;
        }

        .bg-login {
            background-image: url("<?php echo base_url('') ?>/assets_login/images/bg/bg_silog.jpg");
        }
    }

    .mr-5p {

        /*          flex-grow: 3;*/
    }
    </style>
</head>

<body class="nk-body bg-white npc-general pg-auth ui-shady">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <?php //print_r(session()->get()) 
                ?>
                <div class="nk-content bg-login">
                    <div class="nk-block nk-block-middle   wide-xs">
              
                        <div class="card card-bordered" style="height: 100vh;">
                            <div class="card-inner card-inner-lg cs-box-shadow "
                                style=" margin-top: 20%; box-shadow: none;">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content" style="display:flex;justify-content: center;">


                                        <img class="logo-dark logo-img logo-img-lg"
                                            src="<?php echo base_url('') ?>assets_login/images/logo_invis.png"
                                            srcset="<?php base_url('') ?>assets_login/images/logo_invis.png 2x" alt="logo-dark">

                                    </div>
                                </div>
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content" style="display:flex;justify-content: center;">
                                        <h4 class="nk-block-title">Sign-In</h4>
                                    </div>
                                </div>
                                <?php
                                if (isset($cekusername)) {
                                    if (!$cekusername) { ?>
                                <div class="example-alert" style="margin-bottom: 10px;">
                                    <div class="alert alert-danger alert-icon alert-dismissible">
                                        <em class="icon ni ni-cross-circle"></em>Username Salah <button class="close"
                                            data-bs-dismiss="alert"></button>
                                    </div>
                                </div>
                                <?php

                                    }
                                }

                                if (isset($cekpasword)) {
                                    if (!$cekpasword) { ?>
                                <div class="example-alert" style="margin-bottom: 10px;">
                                    <div class="alert alert-danger alert-icon alert-dismissible">
                                        <em class="icon ni ni-cross-circle"></em> Password Salah<button class="close"
                                            data-bs-dismiss="alert"></button>
                                    </div>
                                </div>

                                <?php
                                    }
                                }
                                
                                if (isset($cekerrorapi)) {
                                    if (!$cekerrorapi) { ?>
                                <div class="example-alert" style="margin-bottom: 10px;">
                                    <div class="alert alert-danger alert-icon alert-dismissible">
                                        <em class="icon ni ni-cross-circle"></em>Mohon maaf akun SSO anda tidak bisa digunakan, silahkan hubungi helpdesk DTI<button class="close"
                                            data-bs-dismiss="alert"></button>
                                    </div>
                                </div>

                                <?php
                                    }
                                }
                                 if(isset($checkTUJ)) {
                                    if (!$checkTUJ) { ?>

                                <div class="example-alert" style="margin-bottom: 10px;">
                                    <div class="alert alert-danger alert-icon alert-dismissible">
                                        <em class="icon ni ni-cross-circle"></em> Mohon maaf anda bukan pegawai TELU
                                        JKT<button class="close" data-bs-dismiss="alert"></button>
                                    </div>
                                </div>
                                <?php
                                       }
                                   }

                                   if(isset($notAdmin)) {
                                    if (!$notAdmin) { ?>

                                <div class="example-alert" style="margin-bottom: 10px;">
                                    <div class="alert alert-danger alert-icon alert-dismissible">
                                        <em class="icon ni ni-cross-circle"></em> Mohon maaf anda bukan Admin<button class="close" data-bs-dismiss="alert"></button>
                                    </div>
                                </div>
                                <?php
                                       }
                                   }                                                                                        

                                    echo form_open('SigninProcess', 'class="form-border"') ;
                                
                                ?>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="default-01"> Username SSO</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <input name="username" type="text" class="form-control form-control-lg"
                                            id="default-01" placeholder="Enter your username sso"
                                            value="<?php echo set_value('username') ?>">
                                        <?php
                                        if (isset($validation)) {
                                            // print_r($validation);
                                            if ($validation->hasError('username')) { //untuk mendapatkan label error yang diset bisa menggunakan getError(namfield)

                                        ?>
                                        <span class="badge badge-dim bg-danger" style="">
                                            <?= $validation->getError('username') ?>
                                        </span>


                                        <?php
                                            }
                                        }

                                        ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="password">Password</label>
                                        <!-- <a class="link link-primary link-sm" href="html/pages/auths/auth-reset-v2.html">Forgot Code?</a> -->
                                    </div>
                                    <div class="form-control-wrap">
                                        <a href="#" class="form-icon form-icon-right passcode-switch lg"
                                            data-target="password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input name="password" type="password" class="form-control form-control-lg"
                                            id="password" placeholder="Enter your password"
                                            value="<?php echo set_value('password') ?>" autocomplete="off">
                                        <?php
                                        if (isset($validation)) {
                                            // print_r($validation);
                                            if ($validation->hasError('password')) { //untuk mendapatkan label error yang diset bisa menggunakan getError(namfield)

                                        ?>
                                        <span class="badge badge-dim bg-danger" style="">
                                            <?= $validation->getError('password') ?>
                                        </span>

                                        <?php
                                            }
                                        }


                                        ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <button name="simpan" class="btn btn-lg btn-primary btn-block">Sign in</button>
                                </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="<?php echo base_url('') ?>/assets_login/js/bundle.js?ver=3.2.0"></script>
    <script src="<?php echo base_url('') ?>/assets_login/js/scripts.js?ver=3.2.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>

</html>