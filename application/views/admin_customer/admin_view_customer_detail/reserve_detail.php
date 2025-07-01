<?php $this->load->view('includes/dashlite_header'); ?>
<?php $this->load->view('admin_customer/admin_view_customer_detail/navbar'); ?>

<div class="row">
    <div class="col-12">
        <div class="card card-bordered card-preview">
            <div class="card-inner-group">
                <div class="card-inner">
                    <div class="row">
                        <div class="col-4">
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
                        <div class="col-2">
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
    function filter(){
        var filter_date_start = $("#filter_date_start").val();
        var filter_date_end = $("#filter_date_end").val();

        var redirect_url = "/admin_customer/admin_view_customer_detail/?page=order_detail&customer_id=<?php echo $customer_detail['customer_id'] ?>&";
        var params = [];
        params.push("filter_date_start="+filter_date_start);
        params.push("filter_date_end="+filter_date_end);

        var final_params = params.join("&");
        redirect_url += final_params;
        blockUI_secondary();
        window.location.replace(redirect_url);
    }
</script>
