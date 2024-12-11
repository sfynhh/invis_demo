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

 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
 </script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
 <!--Morris Chart-->
 <script src="<?php echo base_url('') ?>/assets/vendor/raphael/raphael.min.js"></script>
 <script src="<?php echo base_url('') ?>/assets/vendor/morris/morris.min.js"></script>
 <!-- <script src="<?php echo base_url('') ?>/assets/pages/jquery.morris.init.js"></script> -->

 <script src="<?php echo base_url('') ?>/assets/plugins/chartjs/chart.min.js"></script>
 <script src="<?php echo base_url('') ?>/jquery/jquery.mask.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"
     integrity="sha512-K/oyQtMXpxI4+K0W7H25UopjM8pzq0yrVdFdG21Fh5dBe91I40pDd9A4lzNlHPHBIP2cwZuoxaUSX0GJSObvGA=="
     crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/minMaxTimePlugin.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/rangePlugin.js"></script>

 <!-- <script src="<?php echo base_url('') ?>/assets/pages/jquery.chartjs.init.js"></script> -->
 <script type="text/javascript">
function formatAsIndonesiaCurrency(number) {
    try {
        // Convert the number to a float and round to 2 decimal places
        number = parseFloat(number).toFixed(2);

        // Format the number using commas for thousands separator and dot for decimal separator
        let formattedNumber = new Intl.NumberFormat('id-ID').format(number);

        // Add 'Rp' (Rupiah symbol) as the currency prefix
        formattedNumber = `Rp ${formattedNumber}`;

        return formattedNumber;
    } catch (error) {
        return "Invalid input";
    }
}
 </script>