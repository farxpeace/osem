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
            <h3>Customer History</h3>
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

            <?php if(isset($error_message)){ ?>
                <div class="alert alert-fill alert-primary alert-icon">
                    <em class="icon ni ni-alert-circle"></em> <strong>No data</strong>. Please choose customer from the list
                </div>
            <?php } ?>
        </div>
        <?php if(count($customer_detail ?? []) > 0){ ?>
            <div class="col-12 mt-3">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="team">
                            <div class="team-options">
                                <div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li><a href="#"><em class="icon ni ni-focus"></em><span>Edit Name</span></a></li>
                                            <li><a href="#"><em class="icon ni ni-eye"></em><span>Edit Mobile Number</span></a></li>
                                            <li><a href="#"><em class="icon ni ni-mail"></em><span>Edit Membership</span></a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="user-card user-card-s2">

                                <div class="user-info">
                                    <h6 style="font-size: 1.3rem"><?php echo $customer_detail['fullname'] ?></h6>
                                    <span class="sub-text">+<?php echo $customer_detail['mobile_number'] ?></span>
                                </div>
                            </div>
                            <ul class="team-info">
                                <li><span>Is Member</span><span><?php echo ($customer_detail['is_member'] == "yes") ? "✅" : "❌" ?></span></li>
                                <li><span>Join Date</span><span><?php echo $this->far_date->convert_format($customer_detail['create_dttm'] ?? date("Y-m-d"), "l, j M Y"); ?></span></li>
                                <li><span>Total Reservation</span><span><b><?php echo $this->far_reservation->count_available_reservation($customer_detail['customer_id']) ?></b> piece<sup>(s)</sup></span></li>
                            </ul>
                        </div><!-- .team -->
                    </div><!-- .card-inner -->
                </div>
            </div>

            <div class="col-12 mt-3" style="margin-bottom: 100px;">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <ul class="nav nav-tabs nav-tabs-s2 mt-n2" role="tablist" style="grid-template-columns: repeat(2, 1fr); display: grid; ">
                            <li class="nav-item" role="presentation" style="text-align: center;">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tabItem9" aria-selected="true" role="tab" style="font-size: 1.2rem">Reservation</a>
                            </li>
                            <li class="nav-item" role="presentation" style="text-align: center;">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabItem10" aria-selected="false" role="tab" tabindex="-1" style="font-size: 1.2rem">Sales</a>
                            </li>
                        </ul>
                        <div class="tab-content text-center">
                            <div class="tab-pane active show" id="tabItem9" role="tabpanel">

                                <table class="table table-bordered display nowrap" style="text-align: left">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="font-size: 1rem">Product</th>
                                            <th scope="col" style="font-size: 1rem">Available</th>
                                            <th scope="col" style="font-size: 1rem">Action<sup>(s)</sup></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach($this->far_reservation->list_available_reservation_distinct_by_product_id($customer_id) as $a => $b){ ?>
                                    <tr>
                                        <td style="font-size: 1rem"><?php echo $b['product_name'] ?></td>
                                        <td style="font-size: 1rem"><?php echo $b['total_quantity'] ?></td>
                                        <td style="font-size: 1rem"><a href="/reservation/redeem/?product_id=<?php echo $b['product_id'] ?>&customer_id=<?php echo $b['customer_id'] ?>" class="tf-btn accent">Redeem</a></td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                            <div class="tab-pane" id="tabItem10" role="tabpanel">

                                <table class="table table-bordered display nowrap" style="text-align: left">
                                    <thead>
                                    <tr>
                                        <th scope="col" style="font-size: 1rem">Date</th>
                                        <th scope="col" style="font-size: 1rem">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach($this->far_sales->list_sales_by_customer_id($customer_id) as $a => $b){ ?>
                                        <tr>
                                            <td style="font-size: 1rem"><?php echo $this->far_date->convert_format($b['create_dttm'], "D, j M Y h:i A"); ?></td>
                                            <td style="font-size: 1rem">RM <?php echo $b['grand_total'] ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>





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
        $("#customer_id").on("change", function(){
            onchange_customer_id();
        })
    });
    function onchange_customer_id(){
        var customer_id = $("#customer_id").val();

        blockUI_secondary();
        window.location.replace("/reservation/history/?customer_id="+customer_id);
    }
</script>
