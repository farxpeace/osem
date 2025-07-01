<?php $this->load->view('includes/header'); ?>
<?php
$disk = $this->far_helper->list_disk_usage();
?>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat blue-madison">
            <div class="visual">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
				<div class="number">
                    <?php 
                    $query = $this->db->query("SELECT COUNT(uacc_id) AS total_guru FROM user_accounts WHERE uacc_group_fk='4' AND user_status='active'");
                    echo $query->row()->total_guru;
                     ?>
				</div>
				<div class="desc">
                    JUMLAH GURU
				</div>
            </div>
            <a class="more" href="<?php echo base_url(); ?>users/datatable_admin_list_all_user">
                LIHAT LAGI <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat purple">
            <div class="visual">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
				<div class="number">
                    <?php 
                    $query = $this->db->query("SELECT COUNT(uacc_id) AS total_pelajar FROM user_accounts WHERE uacc_group_fk='5' AND user_status='active'");
                    echo $query->row()->total_pelajar;
                     ?>
				</div>
				<div class="desc">
                    JUMLAH PELAJAR
				</div>
            </div>
            <a class="more" href="<?php echo base_url(); ?>users/datatable_admin_list_all_student">
                LIHAT LAGI <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat green">
            <div class="visual">
                <i class="fa fa-folder-open"></i>
            </div>
            <div class="details">
				<div class="number">
                    <?php echo $disk['total']['total_size_nice_format']; ?>
				</div>
				<div class="desc">
                    Media Size
				</div>
            </div>
            <a class="more" href="javascript: void(0);">
                &nbsp;
            </a>
        </div>
    </div>			
</div>



<style>
.progress-title{
    font-size: 18px;
    font-weight: 700;
    color: #000;
    margin: 0 0 10px;
}
.progress-outer{
    background: #fff;
    padding: 5px 60px 5px 5px;
    border: 5px solid #bebfbf;
    border-radius: 45px;
    margin-bottom: 20px;
    position: relative;
}
.progress{
    background: #bebfbf;
    border-radius: 20px;
    margin: 0;
}
.progress .progress-bar{
    border-radius: 20px;
    box-shadow: none;
    animation: animate-positive 2s;
}
.progress .progress-value{
    font-size: 16px;
    font-weight: 700;
    color: #6b7880;
    position: absolute;
    top: 3px;
    right: 2px;
}
@keyframes animate-positive{
    0%{ width: 0; }
}
</style>
<div class="row">
    <div class="col-md-6">
        <h3 class="progress-title">Total Disk Usage (100GB)</h3>
            <div class="progress-outer">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-success" role="progressbar" aria-valuenow="<?php echo $disk['total']['percentage'] ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $disk['total']['percentage'] ?>%">
                        <?php echo $disk['total']['percentage'] ?>%
                    </div>
                    
                    
                    
                    <div class="progress-value total_usage"><span><?php echo $disk['total']['percentage'] ?></span>%</div>
                    
                    
                </div>
            </div>
    </div>
</div>



<?php $this->load->view('includes/footer'); ?>

<script type="text/javascript">
$(document).ready(function(){
    
    $(".total_usage").text("<?php echo $disk['total']['percentage'] ?>%")
    
    
    $('.progress-value > span').each(function(){
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        },{
            duration: 1500,
            easing: 'swing',
            step: function (now){
                $(this).text(Math.ceil(now));
            }
        });
    });
});
</script>