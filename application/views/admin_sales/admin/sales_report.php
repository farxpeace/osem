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
            <h3 class="nk-block-title page-title">Sales Report</h3>
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
                                <label class="form-label">Date Range</label>
                                <div class="form-control-wrap">
                                    <div class="input-daterange date-picker-range input-group">
                                        <input type="text" class="form-control" id="filter_date_start" value="<?php echo $this->far_date->convert($filter_date_start, "Y-m-d", "d/m/Y") ?>" />
                                        <div class="input-group-addon">TO</div>
                                        <input type="text" class="form-control" id="filter_date_end" value="<?php echo $this->far_date->convert($filter_date_end, "Y-m-d", "d/m/Y") ?>" />
                                    </div>
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

                <?php if(count($list_sales) > 0){ ?>
                    <?php foreach($list_sales as $a => $b){ ?>
                    <div class="card-inner">
                        <table class=" nowrap table table-bordered mt-2">
                            <thead>
                            <tr>
                                <th>CUSTOMER</th>
                                <th>DATE</th>
                                <th>TOTAL</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $b['fullname'] ?></td>
                                    <td><?php echo $b['create_dttm'] ?></td>
                                    <td>RM <?php echo $b['grand_total'] ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class=" nowrap table table-bordered mt-2">
                            <thead>
                            <tr>
                                <th style="width: 56px;">NO</th>
                                <th>PRODUCT</th>
                                <th>QUANTITY</th>
                                <th>PRICE</th>
                                <th>TOTAL<sup>(RM)</sup></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $indexproduct = 1; foreach($b['calculate_invoice_array']['item_listing'] as $c => $d){ ?>
                                <tr>
                                    <td><?php echo $indexproduct; ?></td>
                                    <td><?php echo $d['name'] ?></td>
                                    <td><?php echo $d['quantity'] ?></td>
                                    <td><?php echo $d['final_price'] ?></td>
                                    <td><?php echo $d['grand_price'] ?></td>
                                </tr>
                            <?php $indexproduct++; } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                <?php }else{ ?>
                    <div class="card-inner">
                        <div class="alert alert-fill alert-danger alert-icon">
                            <em class="icon ni ni-cross-circle"></em> No record found. Please select another Date
                        </div>
                    </div>

                <?php } ?>

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
        var filter_date_start = $("#filter_date_start").val();
        var filter_date_end = $("#filter_date_end").val();

        var redirect_url = "/admin_sales/sales_report/?";
        var params = [];
        params.push("filter_date_start="+filter_date_start);
        params.push("filter_date_end="+filter_date_end);

        var final_params = params.join("&");
        redirect_url += final_params;
        blockUI_secondary();
        window.location.replace(redirect_url);
    }
</script>
