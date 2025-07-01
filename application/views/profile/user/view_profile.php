<?php $this->load->view('includes/tfpay_header'); ?>

<div class="header mb-1 is-fixed col-12 col-xs-6 col-md-4 offset-md-4 col-lg-6 col-xl-6">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">
            <h3>Profile</h3>
        </div>
    </div>
</div>
<div id="app-wrap">
    <a class="box-profile mt-1" href="<?php echo base_url(); ?>profile/update_profile">
        <div class="inner d-flex align-items-center">
            <div class="info">
                <h2 class="fw_8"><?php echo $logged_in['user_profile']['fullname']; ?></h2>
                <p>Click to update profile</p>
            </div>
        </div>
        <span><i class="icon-right"></i></span>

    </a>
    <ul class="mt-1">
        <li>
            <a href="javascript: void(0);" class="list-profile outline">
                <img src="<?php echo base_url(); ?>assets/barapp/icons/icon_fullname-256x256.png" style="width: 26px;" />
                <p><?php echo $logged_in['user_profile']['fullname']; ?></p>
            </a>
        </li>
        <li>
            <a href="javascript: void(0);" class="list-profile outline">
                <img src="<?php echo base_url(); ?>assets/barapp/icons/icon_nric-256x256.png" style="width: 26px;" />
                <p><?php echo $logged_in['user_profile']['nric_number']; ?></p>
            </a>
        </li>
        <li>
            <a href="javascript: void(0);" class="list-profile outline">
                <img src="<?php echo base_url(); ?>assets/barapp/icons/icon_phone-256x256.png" style="width: 26px;" />
                <p><?php echo $logged_in['uacc_username']; ?></p>
            </a>
        </li>
        <li>
            <a href="javascript: void(0);" class="list-profile outline">
                <img src="<?php echo base_url(); ?>assets/barapp/icons/icon_email-256x256.png" style="width: 26px;" />
                <p><?php echo $logged_in['user_profile']['email']; ?></p>
            </a>
        </li>
    </ul>

    <!--
    <ul class="mt-1">
        <li>
            <a href="<?php echo base_url(); ?>profile/change_password" class="list-profile outline">
                <img src="https://www.svgrepo.com/show/380867/key-password-security-protection-lock.svg" style="width: 26px;" />
                <p>Change Password</p>
                <span><i class="icon-right"></i></span>
            </a>
        </li>
    </ul>
    -->

    <a href="javascript: void(0);" onclick="javascript: btn_click_logout();" class="tf-btn accent large mt-5" style="margin: 5px 10px; width: auto;">Logout</a>
</div>


<?php $this->load->view('includes/tfpay_bottom_navigation_bar'); ?>

<?php $this->load->view('includes/tfpay_footer'); ?>

<script>
    function btn_click_logout(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Logout from system",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00af34',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log me out'
        }).then((result) => {
            if (result.isConfirmed) {
                confirmed_to_logout();
            }
        })
    }
    function confirmed_to_logout(){
        let timerInterval
        Swal.fire({
            title: 'Logout success!',
            html: 'Redirecting to main page in <b></b> milliseconds.',
            icon: 'success',
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                window.location.replace("<?php echo base_url(); ?>auth/logout");
            }
        })
    }
</script>
