<?php $this->load->view('includes/tfpay_header'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker3.standalone.min.css" />
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
    #modal_choose_product_body {
        min-height: 20vh;
        transition: height 0.5s, height 0.5s;
    }
</style>
<div class="header mb-1 is-fixed col-12 col-xs-6 col-md-4 offset-md-4 col-lg-6 col-xl-6">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">
            <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
            <h3>New Sales</h3>
        </div>
    </div>
</div>
<div id="app-wrap">

    <div class="row mt-3 me-1 ms-1">
        <div class="col-12">


            <div class="group-input form-group">
                <label>Customer</label>
                <select class="form-control select2_customer" id="customer_id">
                    <?php foreach($this->far_customer->list_all_customer_simple() as $a => $b){ ?>
                        <option value="<?php echo $b['customer_id'] ?>">
                            <?php if($b['is_member'] == "yes"){ ?>⭐<?php  } ?>
                            <?php echo $b['fullname'] ?> (<?php echo $b['mobile_number'] ?>)</option>
                    <?php } ?>
                </select>
                <span class="help-block error_message" style="display: none;"></span>
                <div class="row mt-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary" onclick="javascript: $('#modal_add_new_customer').modal('show');">Add New Customer</button>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-block btn-secondary" onclick="open_modal_choose_product();">Add Product</button>
            </div>
            <div class="mt-3" id="frame_products">

            </div>



        </div>
    </div>

    <pre><?php //print_r($attendance_detail); ?></pre>
    <pre><?php //print_r($calculate_shift_date); ?></pre>


    <div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
        <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
            <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>auth_admin/dashboard/');" class="tf-btn accent large" style="width: 70px; padding: 5px;"><i class="fa-solid fa-angle-left"></i></a>
            <a href="javascript: void(0);" onclick="javascript: btn_click_submit_checkout();" class="tf-btn accent large">Check-Out</a>
        </div>
    </div>
</div>

<div class="modal modal-bottom fade" id="modal_add_new_customer" tabindex="-1" role="dialog" aria-labelledby="modal_add_new_customer">
    <div class="modal-dialog " role="document" style="margin: 0 auto">
        <div class="modal-content col-md-4 offset-md-4" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <div class="modal-body" id="modal_add_new_customer_body" style="height: 60vh">
                <div class="row">
                    <div class="col-12">
                        <div class="group-input form-group">
                            <label>CUSTOMER NAME</label>
                            <input type="text" id="new_customer_fullname" class="form-control force_uppercase" />
                            <span class="help-block error_message" style="display: none;"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input form-group">
                            <label>CUSTOMER MOBILE</label>
                            <input type="tel" id="new_customer_mobile" class="form-control" />
                            <span class="help-block error_message" style="display: none;"></span>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="group-input form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="new_customer_membership" checked="checked">
                                <label class="custom-control-label" for="new_customer_membership">Check this box if <b>Member Price</b></label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="bottom-navigation-bar bottom-navigation-bar-receipt col-md-4 offset-md-4" style="margin: 0 auto;padding-top: 10px; padding-bottom: 10px;margin-left: -15px;padding-left: 15px; padding-right: 15px;">
                    <div class="tf-container" style="padding: 0px">
                        <div class="group-btn-change-name" style="display: flex; justify-content: space-between; gap: 10px;">
                            <a href="javascript: void(0);" class="tf-btn light large" data-bs-dismiss="modal" aria-label="Close" style="background-color: #a10000; color: #FFFFFF;"><i class="fa-solid fa-circle-xmark"></i> Cancel</a>
                            <a href="javascript: void(0);" class="tf-btn light large" style="background-color: #0214c4; color: #FFFFFF;" onclick="javascript: ajax_add_new_customer();"><i class="fa-solid fa-plus"></i> Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-bottom fade" id="modal_choose_product" tabindex="-1" role="dialog" aria-labelledby="modal_choose_product">
    <div class="modal-dialog " role="document" style="margin: 0 auto">
        <div class="modal-content col-md-4 offset-md-4" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <div class="modal-body" id="modal_choose_product_body" style="height: 40vh">
                <div class="row">
                    <div class="group-input form-group">
                        <label>Product Name</label>
                        <select class="form-control select2" id="add_product_id">
                            <?php foreach($this->far_package->list_all_package() as $a => $b){ ?>
                                <option value="package_<?php echo $b['package_id'] ?>" data-type="package" data-count_available_stock="<?php echo $b['count_available_stock'] ?>">📦 <?php echo $b['package_name'] ?> (Stock : <?php echo $b['count_available_stock'] ?>)</option>
                            <?php } ?>


                            <?php foreach($this->far_product->list_all_product() as $a => $b){ ?>
                                <option value="product_<?php echo $b['product_id'] ?>" data-type="product" data-count_available_stock="<?php echo $b['count_available_stock'] ?>"><?php echo $b['product_name'] ?> (Stock : <?php echo $b['count_available_stock'] ?>)</option>
                            <?php } ?>
                        </select>
                        <span class="help-block error_message" style="display: none;"></span>
                    </div>

                    <div class="group-input form-group">
                        <label>Quantity</label>
                        <div class="form-control-wrap">
                            <div class="form-text-hint">
                                <span class="overline-title">pieces</span>
                            </div>
                            <input type="tel" placeholder="Quantity" id="add_quantity">
                        </div>

                        <span class="help-block error_message" style="display: none;"></span>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button class="btn btn-block btn-primary" onclick="add_to_cart();">Add Product</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input id="cart_id" value="<?php echo $list_added_to_cart["cart_id"] ?? 0; ?>" type="hidden">

<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/js/intlTelInput.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/js/utils.js"></script>
<script>
    $(function(){

        $('.select2').select2({
            dropdownParent: $('#modal_choose_product')
        });
        $(".select2_customer").select2();

        $("#new_customer_mobile").intlTelInput({
            onlyCountries: [
                "my",
                "sg"

            ],
            preferredCountries: [
                "my",
            ],
            separateDialCode: true
        });

        ajax_load_cart("load_cart","");

        $("#customer_id").on("change", function(){
            ajax_load_cart("load_cart","");
        })
    })
</script>
<script>
    function ajax_add_new_customer(){
        var fullname = $("#new_customer_fullname").val();
        var mobile_number = $("#new_customer_mobile").intlTelInput("getNumber");
        var is_member = "no";
        if($('#new_customer_membership').is(':checked')){
            is_member = "yes";
        }

        if(fullname){
            if(fullname.length < 2){
                Swal.fire({
                    icon: "error",
                    title: "Oopss..",
                    text: "Fullname must be greater than 2 characters"
                }); return false;
            }
        } else {
            Swal.fire({
                icon: "error",
                title: "Oopss..",
                text: "Fullname must be greater than 2 characters"
            }); return false;
        }

        if(mobile_number.length < 5){
            Swal.fire({
                icon: "error",
                title: "Oopss..",
                text: "Please check mobile number"
            }); return false;
        }




        var html = "Fullname<br>";
        html += "<b>"+fullname+"</b><br><br>";
        html += "Mobile Number<br>";
        html += "<b>"+mobile_number+"</b><br><br>";

        if(is_member == "yes"){
            html += "✅ Member";
        } else {
            html += "❗ Non-Member";
        }

        Swal.fire({
            title: "Add new customer?",
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
                    url: '<?php echo base_url(); ?>customer/ajax_add_new_customer',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        postdata: {
                            fullname: fullname,
                            mobile_number: mobile_number,
                            is_member: is_member
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == "success"){
                            var newOption = new Option(data.select2_text, data.select2_id, false, false);
                            $('.select2_customer').append(newOption).val(data.select2_id).trigger('change');

                            ajax_load_cart('load_cart');

                            swalTimer('success','Success', 'Customer added', 2000).then(
                                function(value) {
                                    $("#modal_add_new_customer").modal("hide");

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
<script>
    function add_new_customer(){
        blockUI();
        $.ajax({
            url: '<?php echo base_url(); ?>sales/ajax_add_new_customer',
            type: "POST",
            dataType: "JSON",
            data: {
                postdata: {
                    fullname: $("#add_customer_fullname").val(),
                    mobile_number: $("#add_customer_mobile_number").val()
                }
            },
            success: function(data){
                unblockUI();
            }
        })
    }
</script>
<script>
    function add_to_cart(){
        var product_id = $("#add_product_id").val();
        var product_name = $("#add_product_id option:selected").text();
        var quantity = $("#add_quantity").val();
        var customer_id = $("#customer_id").val();


        var type = $("#add_product_id option:selected").data('type');
        if(type == "product"){
            var count_available_stock = $("#add_product_id option:selected").data('count_available_stock');
            if(parseInt(quantity) > parseInt(count_available_stock)){
                Swal.fire({
                    icon: "error",
                    title: "Quantity problem",
                    text: "Quantity must be low or same as available stock",
                });
                return false;
            }
        } else if(type == "package"){
            var count_available_stock = $("#add_product_id option:selected").data('count_available_stock');
            if(parseInt(quantity) > parseInt(count_available_stock)){
                Swal.fire({
                    icon: "error",
                    title: "Quantity problem",
                    text: "Quantity must be low or same as available stock",
                });
                return false;
            }
        }


        var operation_data = {
            product_id: product_id,
            quantity: quantity,
            customer_id: customer_id,
            cart_id: $("#cart_id").val()
        }
        ajax_load_cart('add_to_cart', operation_data);

    }
    function ajax_load_cart(operation, operation_data){
        var postdata = {};
        if(operation == 'add_to_cart'){
            postdata = {
                item: operation_data.product_id,
                quantity: operation_data.quantity,
                operation: 'add_to_cart',
                cart_id: $("#cart_id").val(),
                customer_id: $("#customer_id").val()
            }
            $.ajax({
                url: '<?php echo base_url(); ?>sales/ajax_add_to_cart',
                type: "POST",
                dataType: "JSON",
                data: {
                    postdata: postdata
                },
                success: function(data){
                    if(data.status == "success"){
                        if(data.cart_id){
                            $("#cart_id").val(data.cart_id);
                        }

                        ajax_load_cart('load_cart');
                        $("#modal_choose_product").modal("hide")
                    }else{
                        modal_alert_danger('Unable to process',data.message_single,"")
                    }
                }
            })

        } else if (operation == "load_cart"){
            $("#frame_products").load('<?php echo base_url(); ?>sales/ajax_load_cart_by_cart_id', {
                postdata: {
                    cart_id: $("#cart_id").val(),
                    customer_id: $("#customer_id").val()
                }
            }, function(){

            })
        }

    }
</script>
<script>
    function open_modal_choose_product(){
        $("#modal_choose_product").modal("show");

    }
</script>
<script>
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
                    stock_dttm: $("#stock_dttm").val(),
                    quantity: $("#quantity").val(),
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
<script>
    function remove_product_from_cart(cart_id, item_id){
        Swal.fire({
            title: "Confirmation",
            html: "Remove item from cart?",
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
                    url:"/sales/ajax_remove_product_from_cart",
                    type: 'post',
                    dataType: "JSON",
                    data: {
                        postdata: {
                            cart_id: cart_id,
                            item_id: item_id
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == 'success'){
                            ajax_load_cart("load_cart","");
                            swalTimer('success','Success', 'Product removed from cart', 1000).then(
                                function(value) {

                                },
                            );

                        } else {

                        }

                    }
                });
            }
        });
    }
</script>
<script>
    function edit_quantity(cart_id, item_id, current_quantity){
        Swal.fire({
            title: "Edit quantity",
            input: "number",
            inputValue: current_quantity,
            showCancelButton: true,
            confirmButtonText: "Confirm",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value)
                var quantity = result.value;
                $.ajax({
                    url:"/sales/ajax_edit_product_quantity",
                    type: 'post',
                    dataType: "JSON",
                    data: {
                        postdata: {
                            cart_id: cart_id,
                            item_id: item_id,
                            quantity: quantity
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == 'success'){
                            ajax_load_cart("load_cart","");
                            swalTimer('success','Success', 'Item quantity updated', 1000).then(
                                function(value) {

                                },
                            );

                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oopss..",
                                html: data.message_single,
                            });
                        }

                    }
                });
            }
        });
    }
</script>
<script>
    function btn_click_submit_checkout(){

        var payment_gateway = $('input[name="payment_gateway"]:checked').val();
        if(payment_gateway){

        } else {
            Swal.fire({
                icon: "error",
                title: "Payment method",
                text: "Please choose payment either Cash or E-Wallet"
            });
            return false;
        }



        Swal.fire({
            title: "Confirmation",
            html: "Check out",
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
                    url:"/sales/sales_place_new_order",
                    type: 'post',
                    dataType: "JSON",
                    data: {
                        postdata: {
                            cart_id: $("#cart_id").val(),
                            payment_gateway: payment_gateway
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == 'success'){
                            swalTimer('success','Success', 'Check-out success', 1000).then(
                                function(value) {
                                    if(data.redirect_url){
                                        window.location.replace(data.redirect_url);

                                    }
                                },
                            );

                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oopss..",
                                html: data.message_single
                            });
                        }

                    }
                });
            }
        });
    }
</script>
