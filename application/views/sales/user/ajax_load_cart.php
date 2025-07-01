

<?php if(count($cart_detail['item_listing'] ?? []) > 0){ ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ITEM</th>
                <th>PRICE</th>
                <th>QTY</th>
                <th>TOTAL</th>
                <th></th>
            </tr>
        </thead>

        <?php $no = 0; foreach($cart_detail['item_listing'] as $a => $b){ ?>
        <tbody>
            <tr>
                <td><?php echo $b['name'] ?></td>
                <td><?php echo $b['final_price'] ?></td>
                <td><?php echo $b['quantity'] ?></td>
                <td><?php echo $b['grand_price'] ?></td>
                <td>
                    <ul class="nk-tb-actions gx-1 my-n1">
                        <li class="me-n1">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="javascript: void(0);" onclick="javascript: edit_quantity('<?php echo $cart_detail['cart_id'] ?>','<?php echo $b['item_id'] ?>', '<?php echo $b['quantity'] ?>');"><em class="icon ni ni-edit"></em><span>Edit Quantity</span></a></li>
                                        <!--
                                        <li><a href="javascript: void(0);"><em class="icon ni ni-eye"></em><span>View Product</span></a></li>
                                        -->
                                        <li><a href="javascript: void(0);" onclick="javascript: remove_product_from_cart('<?php echo $cart_detail['cart_id'] ?>','<?php echo $b['item_id'] ?>')"><em class="icon ni ni-trash"></em><span>Remove from cart</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </td>
            </tr>
        </tbody>
        <?php $no++; } ?>
    </table>

    <hr />
    <div class="row">
        <div class="col-6">
            <div class="custom-control custom-radio payment_gateway_control_checkbox" style="display: block">
                <input type="radio" id="payment_gateway_1" name="payment_gateway" class="custom-control-input" value="cash" checked="checked">
                <label class="custom-control-label" for="payment_gateway_1">Cash</label>
            </div>

            <div class="custom-control custom-radio payment_gateway_control_checkbox mt-3" style="display: block">
                <input type="radio" id="payment_gateway_2" name="payment_gateway" class="custom-control-input" value="ewallet">
                <label class="custom-control-label" for="payment_gateway_2">E-Wallet</label>
            </div>
        </div>
        <div class="col-6">
            <div class="alert alert-pro alert-success">
                <div class="alert-text">
                    <h6>RM <?php echo $cart_detail['final_grand_total'] ?></h6>
                    <p>Total price</p>
                </div>
            </div>
        </div>
    </div>


<?php }else{ ?>
    <div class="alert alert-fill alert-info alert-icon mt-3" >
        <em class="icon ni ni-alert-circle"></em> <strong>No item</strong>. Please add product before proceed
    </div>
<?php } ?>

<pre><?php //print_r($cart_detail); ?></pre>
