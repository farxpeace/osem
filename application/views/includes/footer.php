</div>
	</div>
	<!-- END CONTENT -->
	<!-- BEGIN QUICK SIDEBAR -->
	
	
	<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		 <?php echo $this->far_meta->get_value('footer_text'); ?>
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->

<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.alphanumeric.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/select2/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/sweetalert/sweetalert.min.js"></script>

<script type="text/javascript" src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<!-- END CORE PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/MetronicSweetAlert.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/ui-extended-modals.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/form-samples.js"></script>
<script src="<?php echo base_url(); ?>assets/global/scripts/datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/intelmlm/far_datatable.js"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/chance/1.0.11/chance.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/keypress/2.1.4/keypress.min.js"></script>



<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features
    UIExtendedModals.init();
    FormSamples.init();
    TableManaged.init();
    MetronicSweetAlert.init();
});
</script>



<script type="text/javascript">
$.fn.center = function () {
    this.css("position", "absolute");
    this.css("top", ($(window).height() - this.height()) / 2 + $(window).scrollTop() + "px");
    this.css("left", ($(window).width() - this.width()) / 2 + $(window).scrollLeft() + "px");
    return this;
  }
function blockUI() {
    $.blockUI({
      css: {
        backgroundColor: 'transparent',
        border: 'none'
      },
      message: '<div class="spinner"></div>',
      baseZ: 9999999,
      overlayCSS: {
        backgroundColor: '#FFFFFF',
        opacity: 0.7,
        cursor: 'wait'
      }
    });
    $('.blockUI.blockMsg').center();
  }//end Blockui

</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>