<?php $this->load->view('includes/tfpay_header'); ?>
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
            <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
            <h3>Stock History</h3>
        </div>
    </div>
</div>
<div id="app-wrap">

    <div class="row mt-3 me-1 ms-1">
        <div class="col-12">
            <div class="group-input form-group">
                <label>Product Name</label>
                <select class="form-control" id="product_id">
                    <?php foreach($this->far_product->list_all_product() as $a => $b){ ?>
                        <option <?php if($product_id == $b['product_id']){ echo 'selected=""'; } ?> value="<?php echo $b['product_id'] ?>"><?php echo $b['product_name'] ?></option>
                    <?php } ?>
                </select>
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        <div id="stock_listing_mainframe" class="mt-3">

        </div>
    </div>



    <div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
        <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
            <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>auth_admin/dashboard/');" id="btn-popup-up" class="tf-btn accent large"><i class="fa-solid fa-angle-left"></i> Back to Dashboard</a>
        </div>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>

<script>
    $(function(){
        $("#product_id").on("change", function(){
            onchange_product_id();
        });
        onchange_product_id();
    })
    function onchange_product_id(){
        var selected_product_id = $("#product_id").val();
        blockUI_secondary();
        $("#stock_listing_mainframe").load('<?php echo base_url(); ?>product/ajax_frame_stock_history', {
            postdata: {
                product_id: selected_product_id
            }
        }, function(){
            unblockUI();
        })
    }
    function btn_click_submit_add_stock(){
        var error_el;
        reset_form_error();
        blockUI_secondary();
        $.ajax({
            url: '<?php echo base_url(); ?>product/admin_ajax_add_stock',
            type: 'POST',
            dataType: 'json',
            data: {
                postdata: {
                    product_id: $("#product_id").val(),
                    quantity: $("#quantity").val(),
                    remarks: $("#remarks").val()
                }
            },
            success: function(data){
                unblockUI();
                if(data.status == "success"){
                    swalTimer('success','Success', 'Stock updated', 2000).then(
                        function(value) {

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

                    if($(".form-group.has-error").length > 0){
                        var element_scroll = $(".form-group.has-error").get(0);
                        $('html,body').animate({
                            scrollTop: $(".app-section").offset().top - $(window).height()/2
                        }, 500);
                    }

                    modal_alert_danger("Unable to Process!", data.message_single, "");


                }


            }
        });
    }
</script>
