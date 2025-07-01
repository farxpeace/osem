<?php $this->load->view('includes/tfpay_header'); ?>
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
<style>
    .bottom-navigation-bar_stack {
        margin: 0 auto;
        padding-top: 10px;
        padding-bottom: 10px;
        bottom: 60px;
        background: transparent;
        box-shadow: inherit;
    }
</style>
<div class="header mb-1 is-fixed col-12 col-xs-6 col-md-4 offset-md-4 col-lg-6 col-xl-6">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">
            <h3>Crawl API</h3>
        </div>
    </div>
</div>
<div id="app-wrap">

    <div class="row mt-3 me-1 ms-1" style="margin-bottom: 100px;">
        <div class="col-12">
            <div class="alert alert-primary alert-icon">
                <em class="icon ni ni-alert-circle"></em> Last crawl on <?php echo $last_crawl_dttm; ?>
            </div>
        </div>
    </div>




    <div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
        <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
            <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>page/osem/');" class="tf-btn accent large" style="width: 70px; padding: 5px;"><i class="fa-solid fa-angle-left"></i></a>
            <a href="javascript: void(0);" onclick="javascript: btn_click_submit_lead();" class="tf-btn accent large">Crawl now</a>
        </div>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>

<script>
    $(function(){


    });
</script>


<script>
    function btn_click_submit_lead(){
        var error_el;
        reset_form_error();

        Swal.fire({
            title: "Confirmation",
            html: "Crawl API now?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirmed!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                blockUI();
                $.ajax({
                    url: '<?php echo base_url(); ?>osem/ajax_crawl',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        postdata: {

                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == "success"){
                            swalTimer('success','Success', 'API fetched', 2000).then(
                                function(value) {
                                    window.location.href = "/osem/list_all/";
                                },
                            );
                            if(data.redirect_url){
                                //blockUI();
                                setTimeout(function(){
                                    //window.top.location.href = data.redirect_url;
                                }, 2000);
                            }else{

                            }



                        }else{
                            var eell = data.errors;
                            $.each(eell, function(i,j){
                                var el_on_page = $("#"+i).length;
                                if (el_on_page){
                                    $("#"+i).closest('.form-group').addClass('has-error');

                                    if($("#"+i).closest('.form-group').find('.error_message')){
                                        $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                                    }else{
                                        $("#"+i).after('<span class="error_message">'+j+'</span>');
                                        $(".error_message").show();
                                    }

                                } else {
                                    //sweetAlert("Oops...", "Something went wrong!", "error");
                                }
                                console.log(i);
                                console.log(j)
                            });
                            Swal.fire({
                                icon: "error",
                                title: "Unable to Process!",
                                text: data.message_single
                            });


                        }


                    }
                });
            }
        });

    }
</script>
