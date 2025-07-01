<?php $this->load->view('includes/dashlite_header'); ?>
<?php $this->load->view('admin_package/admin_view_package_detail/navbar'); ?>

<div class="row">
    <div class="col-6">
        <div class="card card-bordered">
            <div class="card-inner border-bottom">
                <div class="card-title-group">
                    <div class="card-title">
                        <h6 class="title">PACKAGE DETAIL</h6>
                    </div>
                </div>
            </div>
            <div class="card-inner border-bottom">
                <div class="row mb-3 form-group">
                    <label  class="col-3 col-form-label">PACKAGE NAME</label>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control" id="package_name" value="<?php echo $package_detail['package_name'] ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary btn-dim btn_copy_clipboard"><i class="fa-regular fa-copy"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 form-group">
                    <label  class="col-3 col-form-label">NORMAL PRICE</label>
                    <div class="col-9">
                        <div class="form-control-wrap">
                            <div class="form-icon form-icon-left">
                                <em style="font-size: 12px; font-style: normal; font-weight: bold;">RM</em>
                            </div>
                            <input type="text" class="form-control" id="price_normal" placeholder="Price" value="<?php echo $package_detail['price_normal'] ?>">
                        </div>
                    </div>
                </div>
                <div class="row mb-3 form-group">
                    <label  class="col-3 col-form-label">MEMBER PRICE</label>
                    <div class="col-9">
                        <div class="form-control-wrap">
                            <div class="form-icon form-icon-left">
                                <em style="font-size: 12px; font-style: normal; font-weight: bold;">RM</em>
                            </div>
                            <input type="text" class="form-control" id="price_member" placeholder="Price" value="<?php echo $package_detail['price_member'] ?>">
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-inner">
                <a href="javascript: void(0);" onclick="javascript: btn_update_package();" class="btn btn-primary pull-right">Save <i class="fa-regular fa-paper-plane"></i></a>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card card-bordered">
            <div class="card-inner border-bottom">
                <div class="card-title-group">
                    <div class="card-title">
                        <h6 class="title">PRODUCT LIST</h6>
                    </div>
                </div>
            </div>
            <?php
            $list_product_ids = [];
            if(count($package_detail['list_product']) > 0){
                foreach($package_detail['list_product'] as $a => $b){
                    $list_product_ids[] = $b['product_id'];
                }
            }
            ?>
            <div class="card-inner border-bottom">
                <div class="row mb-3 form-group">
                    <label  class="col-3 col-form-label">PRODUCT NAME</label>
                    <div class="col-9">
                        <div class="input-group">
                            <select class="form-control" id="add_product_id">
                                <?php foreach($list_all_product as $a => $b){ ?>
                                    <?php  if(in_array($b['product_id'], $list_product_ids)){ ?>
                                        <option value="<?php echo $b['product_id'] ?>" disabled="">❌ <?php echo $b['product_name'] ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $b['product_id'] ?>" ><?php echo $b['product_name'] ?></option>
                                    <?php } ?>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 form-group">
                    <label  class="col-3 col-form-label">QUANTITY</label>
                    <div class="col-9">
                        <div class="input-group">
                            <input type="text" class="form-control" id="add_quantity" value="0">
                        </div>
                    </div>
                </div>
                <a href="javascript: void(0);" onclick="javascript: btn_click_add_new_product_list();" class="btn btn-primary pull-right">Add to Package <i class="fa-regular fa-plus"></i></a>
            </div>
            <div class="card-inner border-bottom">
                <?php if(count($package_detail['list_product']) > 0){ ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($package_detail['list_product'] as $a => $b){ ?>
                                <tr>
                                    <td><?php echo $b['product_name'] ?></td>
                                    <td><?php echo $b['product_quantity'] ?></td>
                                    <td><button class="btn btn-sm btn-danger" onclick="delete_product_from_package('<?php echo $b['product_id'] ?>')"><i class="fa-solid fa-xmark"></i></button></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                <?php }else{ ?>
                    <div class="alert alert-info alert-icon">
                        <em class="icon ni ni-alert-circle"></em> <strong>No product</strong>. Please add product into this package
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('includes/dashlite_footer'); ?>
<script>
    function delete_product_from_package(product_id){
        SwalDompet.fire({
            title: "Confirmation",
            html: "Delete product from package?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirmed!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                blockUI();
                $.ajax({
                    url: '<?php echo base_url(); ?>admin_package/ajax_admin_delete_product_from_package',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        postdata: {
                            package_id: '<?php echo $package_detail['package_id'] ?>',
                            product_id: product_id
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == "success"){
                            swalTimer('success','Success', 'Product removed from package', 1500).then(
                                function(value) {
                                    window.location.reload();
                                },
                            );
                        }else{
                            var eell = data.errors;
                            $.each(eell, function(i,j){
                                var el_on_page = $("#"+i).length;
                                if (el_on_page){
                                    $("#"+i).closest('.form-group').addClass('has-error');
                                    $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                                } else {
                                    Swal.fire({
                                        title: "Error",
                                        text: j,
                                        icon: "error"
                                    });
                                }
                                Swal.fire({
                                    title: "Error",
                                    text: j,
                                    icon: "error"
                                });
                            })
                        }
                    }
                })
            }
        });
    }
</script>
<script>
    function btn_click_add_new_product_list(){
        var error_el;
        $(".has-error").removeClass('has-error');
        $(".error_message").hide();

        var product_name = $("#add_product_id option:selected").text();
        var quantity = $("#add_quantity").val()

        Swal.fire({
            title: "Confirmation",
            html: "Add product to package <br><br>Product Name : <b>"+product_name+"</b> <br><br>Package Name : <b><?php echo $package_detail['package_name'] ?></b><br><br>Quantity : "+quantity,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirmed!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                blockUI();
                $.ajax({
                    url: '<?php echo base_url(); ?>admin_package/admin_ajax_add_product_list',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        postdata: {
                            package_id: '<?php echo $package_detail['package_id'] ?>',
                            product_id: $("#add_product_id").val(),
                            quantity: $("#add_quantity").val(),
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == "success"){
                            swalTimer('success','Success', 'Product added to package', 1500).then(
                                function(value) {
                                    window.location.reload();
                                },
                            );
                        }else{
                            var eell = data.errors;
                            $.each(eell, function(i,j){
                                var el_on_page = $("#"+i).length;
                                if (el_on_page){
                                    $("#"+i).closest('.form-group').addClass('has-error');
                                    $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                                } else {
                                    Swal.fire({
                                        title: "Error",
                                        text: j,
                                        icon: "error"
                                    });
                                }
                                Swal.fire({
                                    title: "Error",
                                    text: j,
                                    icon: "error"
                                });
                            })
                        }
                    }
                })
            }
        });
    }
</script>
<script>
    function btn_update_package(){
        var error_el;
        $(".has-error").removeClass('has-error');
        $(".error_message").hide();
        blockUI();
        $.ajax({
            url: '<?php echo base_url(); ?>admin_package/admin_ajax_update_package',
            type: 'POST',
            dataType: 'json',
            data: {
                postdata: {
                    package_id: '<?php echo $package_detail['package_id']; ?>',
                    package_name: $("#package_name").val(),
                    price_normal: $("#price_normal").val(),
                    price_member: $("#price_member").val(),
                }
            },
            success: function(data){
                unblockUI();
                if(data.status == "success"){
                    swalTimer('success','Success', 'Package updated', 1500).then(
                        function(value) {
                            window.location.reload();
                        },
                    );
                }else{
                    var eell = data.errors;
                    $.each(eell, function(i,j){
                        var el_on_page = $("#"+i).length;
                        if (el_on_page){
                            $("#"+i).closest('.form-group').addClass('has-error');
                            $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: j,
                                icon: "error"
                            });
                        }
                        Swal.fire({
                            title: "Error",
                            text: j,
                            icon: "error"
                        });
                    })
                }
            }
        })
    }
</script>