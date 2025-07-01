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
            <h3>Redeem</h3>
        </div>
    </div>
</div>
<div id="app-wrap">

    <div class="row mt-3 me-1 ms-1">

        <div class="col-12">
            <div class="group-input form-group">
                <label>Customer Name</label>
                <select class="form-control" id="customer_id">
                    <option value="0">Please select customer</option>
                    <?php foreach($this->far_customer->list_all_customer_simple() as $a => $b){ ?>

                        <option value="<?php echo $b['customer_id'] ?>" <?php if($b['customer_id'] == $customer_id){ echo "selected='selected'"; } ?>>
                            <?php if($b['is_member'] == "yes"){ ?>⭐<?php  } ?>
                            <?php echo $b['fullname'] ?> (<?php echo $b['mobile_number'] ?>)</option>
                    <?php } ?>
                </select>
                <span class="help-block error_message" style="display: none;"></span>
            </div>

            <div class="group-input form-group">
                <label>Customer Name</label>
                <select class="form-control" id="product_id">
                    <option value="0">Please select product</option>
                    <?php foreach($this->far_product->list_all_product() as $a => $b){ ?>

                        <option value="<?php echo $b['product_id'] ?>" <?php if($b['product_id'] == $product_id){ echo "selected='selected'"; } ?>>
                            <?php echo $b['product_name'] ?> (Stock : <?php echo $b['count_available_stock'] ?>)
                        </option>
                    <?php } ?>
                </select>
                <span class="help-block error_message" style="display: none;"></span>
            </div>

            <?php if(isset($error_message)){ ?>
                <div class="alert alert-fill alert-primary alert-icon">
                    <em class="icon ni ni-alert-circle"></em> <strong>No data</strong>. Please choose customer from the list
                </div>
            <?php } ?>
        </div>


        <?php if(count($product_detail ?? []) > 0){ ?>
        <div class="col-12 mt-3">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="team">
                        <div class="user-card user-card-s2">

                            <div class="user-info">
                                <h6 style="font-size: 1.3rem"><?php echo $product_detail['product_name'] ?></h6>
                                <span class="sub-text"><?php echo strlen($product_detail['product_description'] ?? "") > 50 ? substr($product_detail['product_description'] ?? "",0,50)."..." : $product_detail['product_description'] ?? ""; ?></span>
                            </div>
                        </div>
                        <ul class="team-statistics">
                            <li><span><?php echo $this->far_stock->count_available_stock($product_detail['product_id']) ?></span><span>Available in stockn</span></li>
                            <li><span><?php echo $this->far_reservation->count_available_reservation_by_product($customer_detail['customer_id'], $product_detail['product_id']) ?></span><span>Available for redemption</span></li>
                        </ul>
                    </div><!-- .team -->
                </div><!-- .card-inner -->
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="group-input form-group">
                    <label>Quantity</label>
                    <div class="form-control-wrap">
                        <input type="tel" class="form-control" placeholder="Quantity" id="quantity">
                        <div class="form-text-hint">
                            <span class="overline-title">pieces</span>
                        </div>
                    </div>
                    <span class="help-block error_message" style="display: none;"></span>
                </div>

                <div class="group-input form-group">
                    <label>Remarks</label>
                    <div class="form-control-wrap">
                        <input type="tel" class="form-control" placeholder="Put a remarks here (optional)" id="remarks">

                    </div>
                    <span class="help-block error_message" style="display: none;"></span>
                </div>
            </div>
        </div>
        <?php } ?>


    </div>



    <div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
        <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
            <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>auth_admin/dashboard/');" class="tf-btn accent large" style="width: 70px; padding: 5px;"><i class="fa-solid fa-angle-left"></i></a>
            <a href="javascript: void(0);" onclick="javascript: btn_click_submit_redemption();" class="tf-btn accent large">Submit Redemption</a>
        </div>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>
<script>
    $(function(){
        $("#customer_id,#product_id").on("change", function(){
            onchange_customer_id();
        });
    });
    function onchange_customer_id(){
        var customer_id = $("#customer_id").val();
        var product_id = $("#product_id").val();

        if(parseInt(customer_id) > 0 && parseInt(product_id) > 0){
            blockUI_secondary();
            window.location.replace("/reservation/redeem/?customer_id="+customer_id+"&product_id="+product_id);
        }

    }
</script>

<?php if(count($product_detail ?? []) > 0){ ?>
    <script>
        function btn_click_submit_redemption(){
            var error_el;
            reset_form_error();
            //blockUI_secondary();

            var quantity = $("#quantity").val() || 0;

            if(parseInt(quantity)  == 0){
                Swal.fire({ icon: "error", title: "Quantity problem", text: "Quantity must be greater than 0" }); return false;
            }

            var available_quantity = <?php echo $this->far_reservation->count_available_reservation_by_product($customer_detail['customer_id'], $product_detail['product_id']) ?>;
            if(parseInt(quantity) > parseInt(available_quantity)){
                Swal.fire({ icon: "error", title: "Oopss..", text: "Quantity must be same / lower than "+available_quantity+" pieces" }); return false;
            }

            var html = "Product name:<br><?php echo $product_detail['product_name']; ?><br><br>";
            html += "Quantity : "+quantity+" pieces";

            Swal.fire({

                title: "Redeem this product?",
                html: html,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, confirmed!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    blockUI_secondary();
                    $.ajax({
                        url: '<?php echo base_url(); ?>reservation/ajax_redeem_stock',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            postdata: {
                                product_id: '<?php echo $product_detail["product_id"] ?>',
                                customer_id: '<?php echo $customer_detail["customer_id"] ?>',
                                quantity: quantity,
                                remarks: $("#remarks").val()
                            }
                        },
                        success: function(data){
                            unblockUI();
                            if(data.status == "success"){
                                swalTimer('success','Success', 'Redemption success', 2000).then(
                                    function(value) {
                                        window.location.href = "/reservation/history/?customer_id=<?php echo $customer_detail["customer_id"] ?>";
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
            });


        }
    </script>
<?php } ?>

