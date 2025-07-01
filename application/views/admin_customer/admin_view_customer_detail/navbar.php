<div class="row" style="margin-bottom: 20px;">
    <div class="col-12">
        <div class="card card-bordered">
            <div class="card-aside-wrap">
                <div class="card-content">
                    <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                        <li class="nav-item">
                            <a class="nav-link <?php if($page == 'customer_detail'){ echo "active"; } ?>" href="<?php echo base_url(); ?>admin_customer/admin_view_customer_detail/?page=customer_detail&customer_id=<?php echo $customer_detail['customer_id']; ?>">
                                <i class="fa-solid fa-wallet"></i><span>Customer Detail</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($page == 'order_detail'){ echo "active"; } ?>" href="<?php echo base_url(); ?>admin_customer/admin_view_customer_detail/?page=order_detail&customer_id=<?php echo $customer_detail['customer_id']; ?>">
                                <i class="fa-solid fa-wallet"></i><span>Sales</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($page == 'reserve_detail'){ echo "active"; } ?>" href="<?php echo base_url(); ?>admin_customer/admin_view_customer_detail/?page=reserve_detail&customer_id=<?php echo $customer_detail['customer_id']; ?>">
                                <i class="fa-solid fa-wallet"></i><span>Reserve & Redeem</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>