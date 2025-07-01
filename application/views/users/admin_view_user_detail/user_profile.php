<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('users/admin_view_user_detail/navbar'); ?>
<div class="row">
    <div class="col-md-12 form-horizontal">
        <div class="form-group">
            <label class="col-md-3 control-label">&nbsp;</label>
            <div class="col-md-9 input-large">
                <img class="img-responsive" src="<?php echo $user_profile['profile_picture_url']; ?>" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NAMA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-large" id="fullname" placeholder="Fullname" value="<?php echo $user_profile['fullname']; ?>">
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NO KAD PENGENALAN</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" placeholder="Contoh : 861112235841" id="nric" value="<?php echo $user_detail['nric']; ?>" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">ALAMAT</label>
            <div class="col-md-9">
                <textarea class="form-control input-xlarge" rows="3" id="address"><?php echo $user_detail['address']; ?></textarea>
                
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">TARIKH LAHIR</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge date-picker" id="date_of_birth" value="<?php echo $user_detail['date_of_birth']; ?>" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">TARIKH MASUK KERJA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge date-picker" id="start_working_date" value="<?php echo $user_detail['start_working_date']; ?>" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        
        
        <div class="form-group">
            <label class="col-md-3 control-label">JAWATAN</label>
            <div class="col-md-9">
                <select class="form-control select2me input-xlarge" id="user_role_id">
                    <option></option>
                    <?php foreach($list_all_user_role as $a => $b){ ?>
                    <option value="<?php echo $b['user_role_id']; ?>" <?php if($user_profile['user_role_id'] == $b['user_role_id']){ echo "selected"; } ?>><?php echo $b['user_role_name']; ?></option>
                    <?php } ?>
                </select>
                
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">KELAS MENGAJAR</label>
            <div class="col-md-9">
                <select class="form-control select2me input-xlarge" id="user_department_id">
                    <option></option>
                    <?php foreach($list_all_user_department as $a => $b){ ?>
                    <option value="<?php echo $b['user_department_id']; ?>" <?php if($user_profile['user_department_id'] == $b['user_department_id']){ echo "selected"; } ?>><?php echo $b['user_department_name']; ?></option>
                    <?php } ?>
                </select>
                
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">STATUS</label>
            <div class="col-md-9">
                <select class="form-control input-xlarge select2me" id="user_status">
                    <option value="active" <?php if($user_detail['user_status'] == 'active'){ echo 'selected=""'; } ?>>AKTIF</option>
                    <option value="inactive" <?php if($user_detail['user_status'] == 'inactive'){ echo 'selected=""'; } ?>>TIDAK AKTIF</option>
                </select>
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">TARIKH TAMAT KERJA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge date-picker" id="end_working_date" value="<?php echo $user_detail['end_working_date']; ?>" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-offset-3 col-md-9">
                <button type="button" onclick="javascript: btn_update_profile();" class="btn green">Submit</button>
                <button type="button" onclick="javascript: window.print();" class="btn blue">Print</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/footer'); ?>

<script type="text/javascript">

$(function(){
    $('.date-picker').datepicker({
        orientation: "left",
        autoclose: true,
    });
})
function btn_update_profile(){
    var error_el;
    $(".has-error").removeClass('has-error');
    $(".error_message").hide();
    
    var fullname = $("#fullname").val();
    var nric = $("#nric").val();
    var address = $("#address").val();
    var date_of_birth = $("#date_of_birth").val();
    var start_working_date = $("#start_working_date").val();
    var user_status = $("#user_status").val();
    var end_working_date = $("#end_working_date").val();
    var user_department_id = $("#user_department_id").val();
    var user_role_id = $("#user_role_id").val();
    
    
    
    Metronic.blockUI({
        boxed: true,
        message: 'Sending data to server...'
    });
    $.ajax({
        url: '<?php echo base_url(); ?>users/admin_ajax_update_user',
        type: 'POST',
        dataType: 'json',
        data: { 
            postdata: { 
                uacc_id: '<?php echo $user_detail['uacc_id']; ?>',
                
                fullname: fullname,
                nric: nric,
                address: address,
                date_of_birth: date_of_birth,
                start_working_date: start_working_date,
                user_status: user_status,
                end_working_date: end_working_date,
                user_department_id: user_department_id,
                user_role_id: user_role_id
            } 
        },
        success: function(data){
            Metronic.unblockUI();
            if(data.status == "success"){
                swal({
                    title: "Good job!",
                    text: "User profile updated",
                    type: "success",
                    closeOnConfirm: true
                })
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
