<div class="col-12">
    <div class="card card-bordered pricing">
        <div class="pricing-head">
            <div class="pricing-title">
                <h4 class="card-title title" style="font-size: 1.25rem;"><?php echo $product_detail['product_name'] ?></h4>
                <p class="sub-text"><?php echo strlen($product_detail['product_description'] ?? "") > 50 ? substr($product_detail['product_description'],0,50)."..." : $product_detail['product_description'] ?></p>
            </div>
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

            <div>

            </div>
        </div>
    </div>
</div>