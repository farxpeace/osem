<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('users/admin_view_user_detail/navbar'); ?>


<div class="row">
    <div class="col-md-12 form-horizontal">
        <div class="form-group">
            <label class="col-md-3 control-label">Push Notification Setting</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-large" id="push_notification_on" placeholder="Push Notification Setting" value="<?php echo $user_profile['push_notification_on']; ?>">
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 form-horizontal">
        <div class="form-group">
            <label class="col-md-3 control-label">Email Notification Setting</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-large" id="email_notification_on" placeholder="Email Notification Setting" value="<?php echo $user_profile['email_notification_on']; ?>">
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 form-horizontal">
        <div class="form-group">
            <label class="col-md-3 control-label">Private Profile</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-large" id="private_profile_on" placeholder="Private Profile" value="<?php echo $user_profile['private_profile_on']; ?>">
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('includes/footer'); ?>