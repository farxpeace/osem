<?php $this->load->view('includes/tfpay_header'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker3.standalone.min.css" />
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
            <h3>Add Stock</h3>
        </div>
    </div>
</div>
<div id="app-wrap">

    <div class="row mt-3 me-1 ms-1">
        <div class="col-12">

            <div class="group-input form-group">
                <label>Stock In / Out Date</label>
                <input type="text" id="stock_dttm" value="<?php echo date("Y-m-d"); ?>">
                <span class="help-block error_message" style="display: none;"></span>
            </div>

            <div class="group-input form-group">
                <label>Product Name</label>
                <select class="form-control" id="product_id">
                    <?php foreach($this->far_product->list_all_product() as $a => $b){ ?>
                        <option value="<?php echo $b['product_id'] ?>" data-count_available_stock="<?php echo $b['count_available_stock'] ?>"><?php echo $b['product_name'] ?> (Stock : <?php echo $b['count_available_stock'] ?>)</option>
                    <?php } ?>
                </select>
                <span class="help-block error_message" style="display: none;"></span>
            </div>

            <div class="group-input form-group">
                <label>Quantity</label>

                <div class="form-control-wrap">
                    <?php if($stock_type == 'stock_out'){ ?>
                        <div class="form-icon form-icon-left" style="top: 8px;">
                            <em class="fa-solid fa-minus stock_out"></em>
                        </div>
                    <?php } ?>

                    <input type="tel" class="form-control" placeholder="Quantity" id="quantity">
                    <div class="form-text-hint">
                        <span class="overline-title">pieces</span>
                    </div>

                </div>

                <span class="help-block error_message" style="display: none;"></span>
            </div>

            <div class="group-input form-group">
                <label>Remarks</label>
                <input type="text" placeholder="Put remarks or note here (Optional)" id="remarks">
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
    </div>

    <pre><?php //print_r($attendance_detail); ?></pre>
    <pre><?php //print_r($calculate_shift_date); ?></pre>


    <div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
        <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
            <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>auth_admin/dashboard/');" class="tf-btn accent large" style="width: 70px; padding: 5px;"><i class="fa-solid fa-angle-left"></i></a>
            <a href="javascript: void(0);" onclick="javascript: btn_click_submit_add_stock();" class="tf-btn accent large btn_text_add_deduct_stock">Add Stock</a>
        </div>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function(){
        $('#stock_dttm').datepicker({
            format: "yyyy-mm-dd",
            startView: 2,
            maxViewMode: 2,
            todayBtn: "linked",
            orientation: "bottom left",
            autoclose: true
        });
        if($(".stock_out").length > 0) {
            $(".btn_text_add_deduct_stock").text("Deduct Stock")
        }
    })
</script>
<script>
    function btn_click_submit_add_stock(){
        var error_el;
        reset_form_error();
        //blockUI_secondary();

        var quantity = $("#quantity").val();
        if($(".stock_out").length > 0){
            quantity = "-"+$("#quantity").val()
        }

        var count_available_stock = $("#product_id option:selected").data('count_available_stock');

        if($(".stock_out").length > 0) {
            if (parseInt($("#quantity").val()) > parseInt(count_available_stock)) {
                Swal.fire({
                    icon: "error",
                    title: "Quantity problem",
                    text: "Quantity must be low or same as available stock"
                });
                return false;
            }
        }


        $.ajax({
            url: '<?php echo base_url(); ?>product/admin_ajax_add_stock',
            type: 'POST',
            dataType: 'json',
            data: {
                postdata: {
                    product_id: $("#product_id").val(),
                    stock_dttm: $("#stock_dttm").val(),
                    quantity: quantity,
                    remarks: $("#remarks").val()
                }
            },
            success: function(data){
                unblockUI();
                if(data.status == "success"){
                    swalTimer('success','Success', 'Stock updated', 2000).then(
                        function(value) {
                            window.top.location.href = "<?php echo base_url(); ?>product/stock_history/?product_id="+$("#product_id").val();
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
