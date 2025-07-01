<?php $this->load->view('includes/dashlite_header'); ?>
<?php $this->load->view('admin_customer/admin_view_customer_detail/navbar'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/css/intlTelInput.css">
<style>
    .iti-flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/img/flags.png");}
    @media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
        .iti-flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/img/flags@2x.png");}
    }
    .intl-tel-input {
        width: 100% !important;
    }
</style>
<div class="row">
    <div class="col-6">
        <div class="card card-bordered">
            <div class="card-inner border-bottom">
                <div class="card-title-group">
                    <div class="card-title">
                        <h6 class="title">CUSTOMER DETAIL</h6>
                    </div>
                </div>
            </div>
            <div class="card-inner border-bottom">
                <div class="row mb-3 form-group">
                    <label  class="col-3 col-form-label">CUSTOMER NAME</label>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control" id="fullname" value="<?php echo $customer_detail['fullname'] ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary btn-dim btn_copy_clipboard"><i class="fa-regular fa-copy"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 form-group">
                    <label  class="col-3 col-form-label">MOBILE NUMBER</label>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control editable" id="mobile_number" value="+<?php echo $customer_detail['mobile_number']; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 form-group">
                    <label  class="col-3 col-form-label">IS MEMBER</label>
                    <div class="col-9">
                        <div class="input-group">
                            <div class="form-control-select">
                                <select class="form-control" id="is_member">
                                    <option value="yes" <?php if($customer_detail['is_member'] == "yes"){ echo 'selected=""'; } ?>>✅ YES</option>
                                    <option value="no" <?php if($customer_detail['is_member'] == "no"){ echo 'selected=""'; } ?>>❌ NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 form-group">
                    <label  class="col-3 col-form-label">REGISTERED DATE</label>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control" id="create_dttm" value="<?php echo $customer_detail['create_dttm']; ?>" required>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-inner">
                <a href="javascript: void(0);" onclick="javascript: admin_edit_customer_detail();" class="btn btn-primary pull-right">Save <i class="fa-regular fa-paper-plane"></i></a>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card card-bordered card-full">
            <div class="card-inner border-bottom">
                <div class="card-title-group">
                    <div class="card-title">
                        <h6 class="title">Delete Customer</h6>
                    </div>
                </div>
            </div>
            <div class="card-inner form-horizontal border-bottom">
                <p>This operation cannot be undone. All customer related info won't be deleted from server and database.</p>
            </div>
            <div class="card-inner">
                <a href="javascript: void(0);" onclick="javascript: delete_user();" class="btn btn-danger pull-right">Delete user <i class="fa-regular fa-paper-plane"></i></a>
            </div>
        </div>
    </div>

</div>

<?php $this->load->view('includes/dashlite_footer'); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/js/intlTelInput.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/js/utils.js"></script>
<script>
    $(function(){
        $("#mobile_number").intlTelInput({
            onlyCountries: [
                "my",
                "sg"

            ],
            preferredCountries: [
                "my",
            ],
            separateDialCode: true
        });

        $('#fullname').keyup(function(){
            this.value = this.value.toUpperCase();
        });
    })
</script>
<script>
    function admin_edit_customer_detail(){

        SwalDompet.fire({
            title: 'Are you sure?',
            html: "Update customer details",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            showLoaderOnConfirm: true
        }).then((result) => {
            if (result.isConfirmed) {
                blockUI();
                $.ajax({
                    url: '/admin_customer/ajax_admin_update_customer_detail/',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        postdata: {
                            fullname: $("#fullname").val(),
                            customer_id: '<?php echo $customer_detail['customer_id']; ?>',
                            mobile_number: $("#mobile_number").intlTelInput("getNumber"),
                            is_member: $("#is_member").val()
                        }
                    },
                    success: function(data){
                        if(data.status == "success"){
                            unblockUI();
                            let timerInterval
                            Swal.fire({
                                title: 'Success',
                                html: 'Automatically close in <b></b> milliseconds.',
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
                                    console.log('I was closed by the timer')
                                }
                            })
                            window.location.reload();
                        }else{
                            unblockUI();
                            var eell = data.errors;
                            $.each(eell, function(i,j){
                                var el_on_page = $("#"+i).length;
                                if (el_on_page){
                                    $("#"+i).closest('.form-group').addClass('has-error');
                                    $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                                } else {
                                }
                                SwalDompet.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: j,
                                })
                            });
                        }
                    }
                });
            }
        });
    }
</script>
<script type="text/javascript">
    function delete_user(){
        var html_content = "Confirm delete this customer ?";
        SwalDompet.fire({
            title: 'Are you sure?',
            html: html_content,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            showLoaderOnConfirm: true
        }).then((result) => {
            if (result.isConfirmed) {
                blockUI();
                $.ajax({
                    url: '<?php echo base_url(); ?>admin_customer/ajax_admin_delete_customer/',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        postdata: {
                            customer_id: '<?php echo $customer_detail['customer_id']; ?>'
                        }
                    },
                    success: function(data){
                        if(data.status == "success"){
                            unblockUI();
                            swalTimer('success',"Customer deleted!", "", 2000).then(
                                function(value) {
                                    window.location.href = "/admin_customer/datatable_admin_list_all_customer";
                                },
                            );
                        }else{
                            unblockUI();
                            var eell = data.errors;
                            $.each(eell, function(i,j){
                                var el_on_page = $("#"+i).length;
                                if (el_on_page){
                                    $("#"+i).closest('.form-group').addClass('has-error');
                                    $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                                } else {
                                }
                                SwalDompet.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: j,
                                })
                            });
                        }
                    }
                });
            }
        })
    }
</script>