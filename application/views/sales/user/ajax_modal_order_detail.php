<style>
    #modal_order_detail_body {
        height: 80vh !important;
        padding: 0 !important;
        margin-bottom: 50px;
    }
    .header-style2 {
        background-repeat: no-repeat;
        background-size: cover;
        aspect-ratio: 1 / 1;
    }
</style>
<div class="mb-8">
    <div class="app-section bg_white_color giftcard-detail-section-1">
        <div class="tf-container">
            <div class="voucher-info">
                <h2 class="fw_6"><?php echo $order_detail['order_code'] ?></h2>
            </div>
        </div>
    </div>
    <div class="app-section mt-1 bg_white_color giftcard-detail-section-3">
        <div class="tf-container">
            <div class="d-flex justify-content-between align-items-center top">
                <h4 class="fw_6" style="font-size: 1rem">Product Information</h4>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($cart_detail['item_listing'] as $a => $b){ ?>
                        <tr>
                            <td><?php echo $b['name']; ?></td>
                            <td><?php echo $b['quantity']; ?></td>
                            <td><?php echo $b['grand_price']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="tf-container" style="margin-top: 40px;">
            <div class="d-flex justify-content-between align-items-center top">
                <h4 class="fw_6" style="font-size: 1rem">Customer Information</h4>
            </div>
            <ul class="mt-1">
                <li>
                    <a href="javascript: void(0);" class="list-profile outline">
                        <p>Name</p>
                        <span><?php echo $cart_detail['customer_detail']['fullname'] ?> <?php echo $cart_detail['customer_detail']['mobile_number'] ?></span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="tf-container" style="margin-top: 40px;">
            <div class="d-flex justify-content-between align-items-center top">
                <h4 class="fw_6" style="font-size: 1rem">Order Information</h4>
            </div>
            <ul class="mt-1">
                <li>
                    <a href="javascript: void(0);" class="list-profile outline">
                        <p>Total Price</p>
                        <span>RM <?php echo $this->far_helper->convert_to_currency_format($cart_detail['final_grand_total']); ?></span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="list-profile outline">
                        <p>Grand Price</p>
                        <span>RM <?php echo $this->far_helper->convert_to_currency_format($cart_detail['final_grand_total']); ?></span>
                    </a>
                </li>
            </ul>
        </div>
        <div style="margin-bottom: 100px;">&nbsp;</div>
    </div>



</div>
<div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
    <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
        <a href="javascript: void(0);" data-bs-dismiss="modal" class="tf-btn accent large" style="width: 70px; padding: 5px;background-color: #a10000; color: #FFFFFF;"><i class="fa-solid fa-circle-xmark"></i></a>
        <a href="javascript: void(0);" onclick="javascript: share_invoice('CSS Invoices', 'Invoice', '<?php echo base_url(); ?>page/invoice/?order_code=<?php echo $order_detail['order_code'] ?>');" class="tf-btn accent large btn_submit_new_address">Share Invoice</a>
    </div>
</div>