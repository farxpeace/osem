<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('users/admin_view_user_detail/navbar'); ?>


<div class="row">
    <div class="col-md-12 form-horizontal">
        <div class="form-group">
            <label class="col-md-3 control-label">Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-large" id="name" placeholder="Name" value="<?php echo $user_profile['name']; ?>">
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('includes/footer'); ?>