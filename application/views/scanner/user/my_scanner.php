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

                <div id="qr-reader"></div>
                <div id="qr-reader-results"></div>

            </div>
        </div>
    </div>
</div>

<div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
    <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
        <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>auth_admin/dashboard/');" class="tf-btn accent large" style="width: 70px; padding: 5px;"><i class="fa-solid fa-angle-left"></i></a>
        <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>scanner/my_qrcode/');" class="tf-btn accent large">Show My QR</a>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/URI.js/1.19.11/URI.min.js" integrity="sha512-HBrZaiSIpZkFPGkutbgouEKsfM+HCrfyioscGYbNPPWb7kvMQcfKzMo35yXb+X+eaOOzpu6UkppcJXfKKO/UqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var scanner_admin_allowed_to_scan_guest = "no";
    var resultContainer = document.getElementById('qr-reader-results');
    var lastResult, countResults = 0;

    $(function(){
        open_camera_scan_qrcode();
    });

    function onScanSuccess(decodedText, decodedResult) {
        var process_data_status = ['yes'];
        if($('.modal.show').length > 0) {
            process_data_status.push("no");
        }
        if(Swal.isVisible()){
            process_data_status.push("no");
        }
        if(!inArray("no", process_data_status)){
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;

                process_to_server(decodedText);
            }
        }

    }


    const html5QrCode = new Html5Qrcode("qr-reader");
    const config_scanner = {
        fps: 10,
        qrbox: {
            width: 250,
            height: 250
        }
    };

    function open_camera_scan_qrcode(){
        html5QrCode.start({ facingMode: "environment" }, config_scanner, onScanSuccess);
    }
    function StopQR() { html5QrCode.stop().then((ignore) => {  }).catch((err) => {  }); }


    function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    }
</script>

<script>
    function process_to_server(qrcontent){
        var event_id = $("#event_id").val();
        $.ajax({
            url: "<?php echo base_url() ?>scanner/ajax_process_to_server",
            type: "POST",
            dataType: "JSON",
            data: {
                postdata: {
                    qrcontent: qrcontent,
                    event_id: event_id
                }
            },
            success: function(data){
                if(data.status == 'success'){
                    if(data.page_to_show == 'profile_card'){
                        view_scanned_profile(data.virtual_account_number);
                    } else if(data.page_to_show == 'weblogin'){
                        swalTimer('success','Success', 'Login to desktop success.', 3000).then(
                            function(value) {
                                window.location.href = "<?php echo base_url(); ?>auth_admin/dashboard/";
                            },
                        );

                    } else if(data.page_to_show == 'event_checkin'){

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Scan Success',
                            html: JSON.stringify(data)
                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: JSON.stringify(data)
                    })
                }

            }
        });
        setTimeout(function(){
            lastResult = '';
        }, 3000)
    }
</script>




