<?php echo view('admin/header');  ?> 

<?php echo $contents ?>
<?php echo view('admin/footer'); ?>
 </div>
</div>
	<!-- JAVASCRIPT -->
	<script src="<?php echo base_url('admin/libs/jquery/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('admin/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
	<script src="<?php echo base_url('admin/libs/metismenu/metisMenu.min.js'); ?>"></script>
	<script src="<?php echo base_url('admin/libs/simplebar/simplebar.min.js'); ?>"></script>
	<script src="<?php echo base_url('admin/libs/node-waves/waves.min.js'); ?>"></script>

	<script src="<?php echo base_url('admin/libs/parsleyjs/parsley.min.js'); ?>"></script>
	<script src="<?php echo base_url('admin/js/pages/form-validation.init.js'); ?>"></script>

	<!-- Peity chart-->
	<script src="<?php echo base_url('admin/libs/peity/jquery.peity.min.js'); ?>"></script>

	<!-- Plugin Js-->
	<script src="<?php echo base_url('admin/js/pages/dashboard.init.js'); ?>"></script>

	<!-- Magnific Popup-->
	<script src="<?php echo base_url('admin/libs/magnific-popup/jquery.magnific-popup.min.js'); ?>"></script>

	<!-- Tour init js-->
	<script src="<?php echo base_url('admin/js/pages/lightbox.init.js'); ?>"></script>
	<!-- JAVASCRIPT -->

	<script src="<?php echo base_url('admin/js/app.js'); ?>"></script>

	<script src="<?php echo base_url('admin/js/custom.js'); ?>"></script>

	<!-- Sweet Alerts js -->
	<script src="<?php echo base_url('admin/libs/sweetalert2/sweetalert2.min.js'); ?>"></script>

	<!-- Sweet alert init js-->
	<script src="<?php echo base_url('admin/js/pages/sweet-alerts.init.js'); ?>"></script>

	<!--tinymce js-->
	<script src="<?php echo base_url('admin/libs/tinymce/tinymce.min.js'); ?>"></script>

	<!-- Summernote js -->
	<script src="<?php echo base_url('admin/libs/summernote/summernote-bs4.min.js'); ?> "></script>

	<!-- init js -->
	<script src="<?php echo base_url('admin/js/pages/form-editor.init.js'); ?>"></script>

	<!-- table sorted link -->
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.css">
<script src="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript">
    $(document).ready(function() {
    $('.single').select2();
});
</script>

	</body>
</html>