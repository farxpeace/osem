<?php $this->load->view('includes/tfpay_header'); ?>
<style>
</style>
<div class="header is-fixed col-12 col-xs-6 col-md-4 offset-md-4 col-lg-6 col-xl-6">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">
            <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
            <h3>History</h3>
        </div>
    </div>
</div>
<div id="app-wrap" style="margin-bottom: 50px;">
    <div class="row mt-3 ms-1 me-1">
        <div class="col-8">
            <div class="form-group">
                <div class="form-control-wrap ">
                    <div class="form-control-select">
                        <select class="form-control" id="filter_month">
                            <?php for($month_number = 1; $month_number<=12; $month_number++){ ?>
                                <?php $month_no = date("m", mktime(0, 0, 0, $month_number, 1)) ?>
                                <option <?php if($month_no == $filter_month){ echo 'selected=""'; } ?> value="<?php echo $month_no; ?>"><?php echo date("F", mktime(0, 0, 0, $month_number, 1)); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <div class="form-control-wrap ">
                    <div class="form-control-select">
                        <select class="form-control" id="filter_year">
                            <option value="2024" <?php if($filter_year == '2024'){ echo 'selected=""'; } ?>>2024</option>
                            <option value="2025" <?php if($filter_year == '2025'){ echo 'selected=""'; } ?>>2025</option>
                            <option value="2026" <?php if($filter_year == '2026'){ echo 'selected=""'; } ?>>2026</option>
                            <option value="2027" <?php if($filter_year == '2027'){ echo 'selected=""'; } ?>>2027</option>
                            <option value="2028" <?php if($filter_year == '2028'){ echo 'selected=""'; } ?>>2028</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row mt-3 me-1 ms-1">



        <div class="col-12">
            <div class="card card-bordered card-full">
                <div class="card-inner-group">
                    <?php if(count($list_sales) > 0){ ?>
                        <?php foreach($list_sales as $a => $b){ ?>
                            <div class="card-inner">
                                <div class="project">
                                    <div class="project-head">
                                        <a href="javascript: void(0);" class="project-title">

                                            <div class="project-info">
                                                <h6 class="title"><?php echo $this->far_date->convert_format($b['create_dttm'],'D, j M Y h:i A') ?></h6>
                                                <span class="sub-text">RM <?php echo $b['grand_total'] ?></span>
                                            </div>
                                        </a>
                                        <div class="user-action">
                                            <div class="drodown">
                                                <a href="javascript: void(0);" class="dropdown-toggle btn btn-icon btn-trigger me-n1" onclick="javascript: open_modal_order_detail('<?php echo $b['order_id'] ?>');"><em class="icon ni ni-more-h"></em></a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="project-details">
                                        <p class="sub-text"></p>
                                    </div>



                                </div>
                            </div>
                        <?php } ?>
                    <?php }else{ ?>
                        <div class="alert alert-danger alert-icon">
                            <em class="icon ni ni-cross-circle"></em> <strong>No data</strong>! We did not find any sales for this month
                        </div>
                    <?php } ?>




                </div>
            </div>
        </div>
    </div>

</div>

<pre><?php //print_r($list_sales); ?></pre>
<div class="modal modal-bottom fade" id="modal_order_detail" tabindex="-1" role="dialog" aria-labelledby="modal_order_detail">
    <div class="modal-dialog " role="document" style="margin: 0 auto">
        <div class="modal-content col-md-4 offset-md-4" style="border-top-left-radius: 10px; border-top-right-radius: 10px; ">
            <div class="modal-body" id="modal_order_detail_body">
                <div class="card card-bordered">
                    <div class="card-inner-group">

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
    <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
        <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>auth_admin/dashboard/');" id="btn-popup-up" class="tf-btn accent large"><i class="fa-solid fa-angle-left"></i> Back to Dashboard</a>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>
<script>
    function open_modal_order_detail(order_id){
        blockUI_secondary();
        setTimeout(function(){
            $("#modal_order_detail_body").load('/sales/ajax_modal_order_detail', {
                postdata: {
                    order_id: order_id
                }
            }, function(){
                unblockUI();
                $("#modal_order_detail").modal("show");
            })
        }, 1000)
    }
</script>
<script>
    $("#filter_month").on("change", function(){
        onchange_filter_month_and_year();
    });
    $("#filter_year").on("change", function(){
        onchange_filter_month_and_year();
    });
    function onchange_filter_month_and_year(){
        var filter_month = $("#filter_month").val();
        var filter_year = $("#filter_year").val();

        blockUI_secondary();
        window.location.replace("<?php echo base_url(); ?>sales/my_sales_history/?filter_month="+filter_month+"&filter_year="+filter_year);
    }
</script>