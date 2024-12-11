<?php echo $this->extend('partials/navbar') ?>

<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->
<?= $this->section('script') ?>
 <!-- jQuery  -->
        <script src="<?php echo base_url('') ?>/assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url('') ?>/assets/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url('') ?>/assets/js/metisMenu.min.js"></script>
        <script src="<?php echo base_url('') ?>/assets/js/waves.min.js"></script>
        <script src="<?php echo base_url('') ?>/assets/js/jquery.slimscroll.min.js"></script>
        <!-- filepond -->
         <script src="<?php echo base_url('') ?>/assets/extension/filepond/filepond.js"></script>
         <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>

        <script src="<?php echo base_url('') ?>/assets/plugins/moment/moment.js"></script>
              <script src="<?php echo base_url('') ?>/assets/plugins/select2/select2.min.js"></script>

        <!-- Required datatable js -->
        <script src="<?php echo base_url('') ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url('') ?>/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>

        <script src="<?php echo base_url('') ?>/assets/pages/jquery.dashboard-2.init.js"></script>

        <!-- App js -->
        <script src="<?php echo base_url('') ?>/assets/js/app.js"></script>


        <!--Morris Chart-->
           <script src="<?php echo base_url('') ?>/assets/vendor/raphael/raphael.min.js"></script>
          <script src="<?php echo base_url('') ?>/assets/vendor/morris/morris.min.js"></script>
        <!-- <script src="<?php echo base_url('') ?>/assets/pages/jquery.morris.init.js"></script> -->

          <script src="<?php echo base_url('') ?>/assets/plugins/chartjs/chart.min.js"></script>
           <!-- <script src="<?php echo base_url('') ?>/assets/pages/jquery.chartjs.init.js"></script> -->
        <!-- filepomnd -->
       



<?= $this->endSection() ?>