<div class="team">
    <div class="user-card user-card-s2">
        <div class="user-info">
            <h6><?php echo $customer_detail['fullname'] ?></h6>
            <span class="sub-text"><?php echo $customer_detail['mobile_number'] ?></span>
        </div>
    </div>
    <div class="team-details" style="max-width: none">
        <div class="card-text">
            <div class="row">
                <div class="col-4">
                    <span class="h4 fw-500" style="font-size: 1.5rem; font-weight: 700;"><?php echo ($customer_detail['is_member'] == "yes") ? "✅" : "❌" ?></span>
                    <span class="sub-text">Is Member</span>
                </div>
                <div class="col-4">
                    <span class="h4 fw-500" style="font-size: 1.5rem; font-weight: 700;"><?php echo $this->far_date->convert_format($customer_detail['create_dttm'] ?? date("Y-m-d"), "j M Y"); ?></span>
                    <span class="sub-text">Join Date</span>
                </div>
                <div class="col-4">
                    <span class="h4 fw-500" style="font-size: 1.5rem; font-weight: 700;"><?php echo $this->far_reservation->count_available_reservation($customer_detail['customer_id']) ?></span>
                    <span class="sub-text">Reserved</span>
                </div>
            </div>

        </div>
    </div>
    <div class="team-view mt-3">
        <a href="admin_customer/admin_view_customer_detail/?page=customer_detail&customer_id=<?php echo $customer_detail['customer_id'] ?>" class="btn btn-round btn-outline-light w-150px"><span>View Customer</span></a>
    </div>
</div><!-- .team -->