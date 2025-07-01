<div class="row" style="margin-bottom: 20px;">
    <div class="col-12">
        <div class="card card-bordered">
            <div class="card-aside-wrap">
                <div class="card-content">
                    <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                        <li class="nav-item">
                            <a class="nav-link <?php if($page == 'package_detail'){ echo "active"; } ?>" href="<?php echo base_url(); ?>admin_package/admin_view_package_detail/?page=package_detail&package_id=<?php echo $package_detail['package_id']; ?>">
                                <i class="fa-solid fa-wallet"></i><span>Package Information</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>