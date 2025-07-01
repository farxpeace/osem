<div class="team">
    <div class="user-card user-card-s2">
        <div class="user-info">
            <h6><?php echo $product_detail['product_name'] ?></h6>
            <span class="sub-text"><?php echo strlen($product_detail['product_description'] ?? "") > 100 ? substr($product_detail['product_description'] ?? "",0,100)."..." : $product_detail['product_description'] ?? ""; ?></span>
        </div>
    </div>
    <div class="team-details" style="max-width: none">
        <div class="card-text">
            <div class="row">
                <div class="col-4">
                    <span class="h4 fw-500" style="font-size: 1.5rem; font-weight: 700;"><?php echo $this->far_stock->count_stock_in($product_detail['product_id']) ?></span>
                    <span class="sub-text">In</span>
                </div>
                <div class="col-4">
                    <span class="h4 fw-500" style="font-size: 1.5rem; font-weight: 700;"><?php echo $this->far_stock->count_available_stock($product_detail['product_id']) ?></span>
                    <span class="sub-text">Available</span>
                </div>
                <div class="col-4">
                    <span class="h4 fw-500" style="font-size: 1.5rem; font-weight: 700;"><?php echo $this->far_stock->count_stock_out($product_detail['product_id']) ?></span>
                    <span class="sub-text">Out</span>
                </div>
            </div>

        </div>
    </div>
    <div class="team-view mt-3">
        <a href="admin_product/admin_view_product_detail/?page=product_detail&product_id=<?php echo $product_detail['product_id'] ?>" class="btn btn-round btn-outline-light w-150px"><span>View Product</span></a>
    </div>
</div><!-- .team -->