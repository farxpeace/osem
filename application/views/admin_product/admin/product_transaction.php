<?php $this->load->view('includes/dashlite_header'); ?>
<style>
    .badge_parent {
        padding-left: 0px;
        min-width: 140px;
    }
    .badge_title {
        background-color: #FFFFFF;
        color: #000000;
        font-style: normal;
        padding: 0 5px;
        border-radius: 2px;
        margin-right: 5px;
    }
    .badge_title_order {
        width: 50px;
    }
    .badge_title_dms {
        width: 50px;
    }
    .badge_title_profile {
        width: 50px;
    }
    .time {
        display: block;
        font-size: 12px;
        color: #8094ae;
        line-height: 1.3;
    }
</style>
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">Product Transaction</h3>
        </div><!-- .nk-block-head-content -->
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">

                    </ul>
                </div>
            </div>
        </div><!-- .nk-block-head-content -->
    </div><!-- .nk-block-between -->
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-bordered card-preview">
            <div class="card-inner-group">
                <div class="card-inner">
                    <div class="row">

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Products</label>
                                <div class="form-control-select">
                                    <select class="form-control" id="filter_product_id">
                                        <option value="0">Please select Product</option>
                                        <option value="all" <?php if($filter_product_id == 'all'){ echo 'selected=""'; } ?>>⭐ All Product</option>
                                        <?php foreach($this->far_product->list_all_product() as $a => $b){ ?>
                                            <option value="<?php echo $b['product_id'] ?>" <?php if($filter_product_id== $b['product_id']){ echo "selected=''"; } ?>><?php echo strtoupper($b['product_name']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-md-2">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">&nbsp;</label>
                                <button type="button" class="btn btn-block btn-primary" onclick="filter();">Filter</button>
                            </div>

                        </div>
                    </div>
                </div>
                <div id="frame_load_monthly_report">
                    <?php if(count($final_list) > 0){ ?>
                        <?php foreach($final_list as $a => $b){ ?>
                            <div class="card-inner">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <table class=" nowrap table table-bordered" data-export-title="Export">
                                            <tbody>
                                                <tr>
                                                    <td><b>PRODUCT NAME</b></td>
                                                    <td><?php echo strtoupper($b['product_detail']['product_name']) ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>AVAILABLE STOCK</b></td>
                                                    <td><?php echo $b['product_detail']['current_stock'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>TOTAL IN</b></td>
                                                    <td><?php echo $this->far_stock->count_stock_in($b['product_detail']['product_id']) ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>TOTAL OUT</b></td>
                                                    <td><?php echo $this->far_stock->count_stock_out($b['product_detail']['product_id']) ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>ACTION</b></td>
                                                    <td>
                                                        <a href="javascript:;" class="btn btn-primary me-2" onclick="open_modal_add_stock('add', '<?php echo $b['product_detail']['product_id'] ?>');"><i class="fa fa-plus"></i> ADD NEW STOCK </a>
                                                        <a href="javascript:;" class="btn btn-danger" onclick="open_modal_add_stock('deduct', '<?php echo $b['product_detail']['product_id'] ?>');"><i class="fa fa-minus"></i> DEDUCT STOCK </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <table class=" nowrap table table-bordered mt-2" data-export-title="Export">
                                    <thead>
                                    <tr>
                                        <th>DATE</th>
                                        <th>QUANTITY</th>
                                        <th>REMARKS</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($b['list_transaction'] as $c => $d){ ?>
                                        <tr>
                                            <td><?php echo $d['create_dttm'] ?></td>
                                            <td><?php echo $d['quantity'] ?></td>
                                            <td><?php echo $d['remarks'] ?></td>
                                            <td>
                                                <a href="javascript: void(0);" onclick="javascript: quick_delete_product_stock('<?php echo $d['product_stock_id'] ?>');" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> DELETE</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        <?php } ?>
                    <?php }else{ ?>
                        <div class="card-inner">
                            <div class="alert alert-fill alert-danger alert-icon">
                                <em class="icon ni ni-alert-circle"></em> <strong>No data</strong>. Please choose Product
                            </div>
                        </div>
                    <?php } ?>

                </div>

            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modal_add_new_stock">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ADD NEW STOCK</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="add_stock_quantity">QUANTITY</label>
                        <div class="form-control-wrap">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="quantity_indicator_positive_negative">+</span>
                                </div>
                                <input type="text" class="form-control" id="add_stock_quantity" required>
                                <div class="form-text-hint">
                                    <span class="overline-title">PIECES</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="add_stock_quantity">REMARKS</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="add_stock_remarks" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <input type="hidden" id="quantity_negative_positive">
                <input type="hidden" id="product_id">
                <button type="button" onclick="javascript: btn_click_add_new_stock_list();" class="btn btn-lg btn-primary pull-right">SUBMIT</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/dashlite_footer'); ?>

<script>
    $(function(){

    });

</script>
<script>
    function filter(){
        var filter_product_id = $("#filter_product_id").val();

        var redirect_url = "/admin_product/product_transaction/?";
        var params = [];
        params.push("filter_product_id="+filter_product_id);

        var final_params = params.join("&");
        redirect_url += final_params;
        blockUI_secondary();
        window.location.replace(redirect_url);
    }
</script>
<script>

    function onchange_filter_shift_date_type(){
        var filter_shift_date_type = $("#filter_shift_date_type").val();
        if(parseInt(filter_shift_date_type) > 0){
            $("#frame_filter_shift_date_year").show();
        } else {
            $("#frame_filter_shift_date_year").hide();
        }

        redirect_filter_shift_date()
    }
    function set_filter_shift_date(){

    }
    function lastDateOfMonth(y, m){
        // Create a new Date object representing the last day of the specified month
        // By passing m + 1 as the month parameter and 0 as the day parameter, it represents the last day of the specified month
        return new Date(y, m + 1, 0).getDate();
    }
    function redirect_filter_shift_date(){

        var redirect_url = "/admin_attendance/datatable_admin_list_all_attendance/?";
        var params = [];
        var filter_shift_date_type = $("#filter_shift_date_type").val();
        var filter_shift_date_startrange = $('#filter_shift_date input[name=start]').data('datepicker').getFormattedDate('yyyy-mm-dd');
        var filter_shift_date_endrange = $('#filter_shift_date input[name=end]').data('datepicker').getFormattedDate('yyyy-mm-dd');
        if(filter_shift_date_type == 'custom_range'){
            params.push("filter_shift_date_type=custom_range");
            if(filter_shift_date_startrange.length > 3 && filter_shift_date_endrange.length > 3){
                params.push("start="+filter_shift_date_startrange);
                params.push("end="+filter_shift_date_endrange);
            }
        } else if(filter_shift_date_type == 'all'){
            params.push("filter_shift_date_type=all");
            params.push("start=2025-01-01");
            params.push("end=2030-12-31");
        } else if(parseInt(filter_shift_date_type) > 0){
            params.push("filter_shift_date_type="+filter_shift_date_type);
            var month = filter_shift_date_type;
            var year = $("#filter_shift_date_year").val();
            params.push("filter_month="+month);
            params.push("filter_year="+year);

            //start
            var firstDateofMonth = year+"-"+month+"-01";
            params.push("start="+firstDateofMonth);
            //end
            var lastDateOfMonthFinal = lastDateOfMonth(month, year);
            params.push("end="+lastDateOfMonthFinal);
        }
        var final_params = params.join("&");
        redirect_url += final_params;
        blockUI_secondary();
        window.location.replace(redirect_url);
        console.log(redirect_url);


    }

</script>

<script type="text/javascript">
    function open_modal_add_product(){
        $('#modal_add_new_product').modal({
            backdrop: 'static',
            keyboard: false
        });
    }
</script>
<script>
    function btn_click_add_new_product(){
        var error_el;
        $(".has-error").removeClass('has-error');
        $(".error_message").hide();
        var post_title = $("#post_title").val();
        Metronic.blockUI({
            boxed: true,
            message: 'Sending data to server...'
        });
        $.ajax({
            url: '<?php echo base_url(); ?>admin_product/admin_ajax_add_product',
            type: 'POST',
            dataType: 'json',
            data: {
                postdata: {
                    post_title: post_title
                }
            },
            success: function(data){
                Metronic.unblockUI();
                if(data.status == "success"){
                    swal({
                        title: "Success!",
                        text: "Product added. Please update information in the next page",
                        type: "success",
                        closeOnConfirm: true
                    },function(){
                        window.location.href = data.redirect_url;
                    })
                }else{
                    var eell = data.errors;
                    $.each(eell, function(i,j){
                        var el_on_page = $("#"+i).length;
                        if (el_on_page){
                            $("#"+i).closest('.form-group').addClass('has-error');
                            $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                        } else {
                            sweetAlert("Oops...", "Something went wrong!", "error");
                        }
                        console.log(i);
                        console.log(j)
                    })
                }
            }
        })
    }
</script>


<script type="text/javascript">
    function quick_delete_product_stock(product_stock_id){
        SwalDompet.fire({
            title: "Are you sure?",
            html: "This action cannot be undone",
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
                    url: "/admin_product/ajax_admin_delete_product_stock_id",
                    type: "POST",
                    dataType: "json",
                    data: {
                        postdata: {
                            product_stock_id: product_stock_id
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == "success"){
                            swalTimer('success',"Success", "Stock deleted", 2000).then(
                                function(value) {
                                    window.location.reload()
                                },
                            );
                        } else {
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
                })
            }
        });
    }
    var titleCase = function(s) {
        if (!s) return;
        s = s.toLocaleLowerCase().split(" ");
        var ss = "";
        for(i in s) {
            ss += s[i].substr(0,1).toUpperCase() + s[i].substr(1);
            ss += " ";
        }
        return ss.trim();
    }
</script>

<script type="text/javascript">
    function open_modal_add_stock(type, product_id){


        if(type == 'deduct'){
            $("#modal_add_new_stock .modal-title").text("DEDUCT STOCK");
            $("#quantity_indicator_positive_negative").text("-");
            $("#quantity_negative_positive").val("negative")
        } else if(type == 'add'){
            $("#modal_add_new_stock .modal-title").text("ADD NEW STOCK")
            $("#quantity_indicator_positive_negative").text("+")
            $("#quantity_negative_positive").val("positive")
        }

        $("#product_id").val(product_id);
        $('#modal_add_new_stock').modal("show")
    }
</script>

<Script>
    function btn_click_add_new_stock_list(){
        var error_el;
        $(".has-error").removeClass('has-error');
        $(".error_message").hide();

        var quantity = $("#add_stock_quantity").val();
        var quantity_negative_positive = $("#quantity_negative_positive").val();
        if(quantity_negative_positive == 'negative'){
            quantity = "-"+quantity;
        }

        var product_id = $("#modal_add_new_stock").find('#product_id').val();

        SwalDompet.fire({

            title: "Confirmation",
            html: "Add <b>"+quantity+"</b> pieces?",
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
                    url: '/admin_product/admin_ajax_add_stock_list',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        postdata: {
                            product_id: product_id,
                            quantity: quantity,
                            remarks: $("#add_stock_remarks").val(),
                        }
                    },
                    success: function(data){
                        unblockUI()
                        if(data.status == "success"){
                            swalTimer('success',"Stock added", "Automatically close in <b></b> milliseconds.", 2000).then(
                                function(value) {
                                    window.location.reload()
                                },
                            );
                        }else{
                            var eell = data.errors;
                            $.each(eell, function(i,j){
                                var el_on_page = $("#"+i).length;
                                if (el_on_page){
                                    $("#"+i).closest('.form-group').addClass('has-error');
                                    $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                                } else {

                                }
                                SwalDompet.fire({
                                    icon: "error",
                                    title: "Oopss..",
                                    text: j
                                });
                            })
                        }
                    }
                })
            }
        });



    }
</Script>