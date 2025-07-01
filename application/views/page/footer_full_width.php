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
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>


<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/sweetalert/sweetalert.min.js"></script>
<!-- END CORE PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/MetronicSweetAlert.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/ui-extended-modals.js"></script>

<script src="<?php echo base_url(); ?>assets/global/scripts/datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/intelmlm/far_datatable.js"></script>
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features
    UIExtendedModals.init();
    TableManaged.init();
    MetronicSweetAlert.init();
});
</script>
<?php
$session_data = unserialize($_SESSION["auypek"] ?? "") ?? "";
//if havce, validate
if(is_array($session_data) && count($session_data) > 0){
    //get session key
    $al_username = $session_data['al_username'];
    $al_userid = $session_data['al_userid'];
    $al_sec_key = $session_data['al_sec_key'];
    $md5_userid = md5($al_userid.'@h56fy');
    $al_button = 'no';
    if($md5_userid == $al_sec_key){
        $random_string = $this->far_helper->generateRandomString(40,"0123456789abcdefghijklmnopqrstuvwxyz");
        $masked_sec_key = $random_string.'tt2m3'.$al_sec_key;
        $al_button = 'yes';
    }
}
?>
<!-- Hack to remove dashboard - main -->
<script type="text/javascript">
$(function(){
    $("a[href='<?php echo base_url(); ?>auth_admin/dashboard']").closest('ul.sub-menu').remove();
});
</script>
<script type="text/javascript">
$.fn.center = function () {
    this.css("position", "absolute");
    this.css("top", ($(window).height() - this.height()) / 2 + $(window).scrollTop() + "px");
    this.css("left", ($(window).width() - this.width()) / 2 + $(window).scrollLeft() + "px");
    return this;
  }
</script>
<script type="text/javascript">
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
function open_top_href(href){
    blockUI();
    window.top.location.href = href;
    $.unblockUI();
}
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>