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
            <h3 class="nk-block-title page-title">Packages</h3>
        </div><!-- .nk-block-head-content -->
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt">
                            <a href="void(0);" onclick="open_modal_add_package()" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add Package</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!-- .nk-block-head-content -->
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-bordered card-preview">
            <div class="card-inner-group">

                <div class="card-inner">
                    <table class=" nowrap table table-bordered mt-2" data-export-title="Export">
                        <thead>
                        <tr>
                            <th>NO</th>
                            <th>PACKAGE NAME</th>
                            <th>QUANTITY</th>
                            <th>MEMBER PRICE</th>
                            <th>NON MEMBER PRICE</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_all_package as $a => $b){ ?>
                            <tr>
                                <td><?php echo ($a+1) ?></td>
                                <td><?php echo $b['package_name'] ?></td>
                                <td></td>
                                <td><?php echo $b['price_member'] ?></td>
                                <td><?php echo $b['price_normal'] ?></td>
                                <td>
                                    <a href="javascript: void(0);" onclick="javascript: quick_delete('<?php echo $b['package_id'] ?>');" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> &nbsp;</a>
                                    <a href="/admin_package/admin_view_package_detail/?page=package_detail&package_id=<?php echo $b['package_id'] ?>" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> VIEW</a>
                                </td>
                            </tr>
                            <?php foreach($b['list_product'] as $c => $d){ ?>
                                <tr>
                                    <td></td>
                                    <td><i class="fa-solid fa-arrow-right-long" style="color: #63E6BE;"></i> <?php echo $d['product_name'] ?></td>
                                    <td><?php echo $d['product_quantity'] ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modal_add_new_package">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Package Detail</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="full-name">Package Name</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control uppercase" id="new_package_name" required>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer bg-light">

                <button type="button" onclick="javascript: btn_click_add_new_package();" class="btn btn-lg btn-primary pull-right">Create</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/dashlite_footer'); ?>

<script>
    $(function(){

    });

</script>

<script type="text/javascript">
    function quick_delete(package_id){
        SwalDompet.fire({
            title: "Are you sure?",
            html: "Delete this package ?",
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
                    url: "/admin_package/ajax_admin_delete_package",
                    type: "POST",
                    dataType: "json",
                    data: {
                        postdata: {
                            package_id: package_id
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == "success"){
                            swalTimer('error','Success', 'Package deleted', 1500).then(
                                function(value) {
                                    window.location.reload();
                                },
                            );
                        } else {
                            sweetAlert("Oops...", "Something went wrong!", "error");
                        }
                    }
                })
            }
        });
    }
</script>

<script type="text/javascript">
    function open_modal_add_package(){
        $('#modal_add_new_package').modal('show');
    }
</script>
<script>
    function btn_click_add_new_package(){
        var error_el;
        $(".has-error").removeClass('has-error');
        $(".error_message").hide();
        blockUI();
        $.ajax({
            url: 'https://bar-app.test/admin_package/admin_ajax_add_package',
            type: 'POST',
            dataType: 'json',
            data: {
                postdata: {
                    package_name: $("#new_package_name").val()
                }
            },
            success: function(data){
                unblockUI();
                if(data.status == "success"){
                    swalTimer('success','Success', 'Package added. Please update information in the next page', 2500).then(
                        function(value) {
                            window.location.href = data.redirect_url;

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
                            sweetAlert("Oops...", "Something went wrong!", "error");
                        }
                        console.log(i);
                        console.log(j)
                    })
                }
            }
        })
    }
</script>


<script type="text/javascript">
    var titleCase = function(s) {
        if (!s) return;
        s = s.toLocaleLowerCase().split(" ");
        var ss = "";
        for(i in s) {
            ss += s[i].substr(0,1).toUpperCase() + s[i].substr(1);
            ss += " ";
        }
        return ss.trim();
    }
</script>