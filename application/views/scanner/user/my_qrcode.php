<?php $this->load->view('includes/tfpay_header'); ?>
<style>
    body {
        background-color: #f5f5f5 !important;
    }
</style>
<div class="header is-fixed col-md-4 offset-md-4">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">
            <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
            <h3>Scanner</h3>
        </div>
    </div>
</div>
<div id="app-wrap">
    <div class="tf-container">
        <div class="row" style="margin-top: 50px;">
            <div class="col-12">
                <div class="card card-bordered">
                    <div id="show_my_qrcode"></div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
    <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
        <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>auth_admin/dashboard/');" class="tf-btn accent large" style="width: 70px; padding: 5px;"><i class="fa-solid fa-angle-left"></i></a>
        <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>scanner/my_scanner/');" class="tf-btn accent large">Open QR Scanner</a>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js" integrity="sha512-NFUcDlm4V+a2sjPX7gREIXgCSFja9cHtKPOL1zj6QhnE0vcY695MODehqkaGYTLyL2wxe/wtr4Z49SvqXq12UQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(function(){
        $('#show_my_qrcode').qrcode("<?php echo base_url(); ?>me/<?php echo $this->far_users->get_virtual_account_number($logged_in['uacc_id']); ?>");
        console.log("<?php echo base_url(); ?>me/<?php echo $this->far_users->get_virtual_account_number($logged_in['uacc_id']); ?>")
    });
</script>



