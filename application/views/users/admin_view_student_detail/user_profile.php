<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('users/admin_view_student_detail/navbar'); ?>
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
            <label class="col-md-3 control-label">NO MYKID</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" placeholder="Contoh : 861112235841" id="mykid" value="<?php echo $user_detail['mykid']; ?>" />
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
            <label class="col-md-3 control-label">TARIKH MASUK TASKA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge date-picker" id="tarikh_masuk_taska" value="<?php echo $user_detail['tarikh_masuk_taska']; ?>" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        
        <div class="form-group">
            <label class="col-md-3 control-label">NAMA IBU</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="nama_ibu" value="<?php echo $user_detail['nama_ibu']; ?>" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NO TEL IBU</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="no_tel_ibu" value="<?php echo $user_detail['no_tel_ibu']; ?>" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">PEKERJAAN IBU</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="pekerjaan_ibu" value="<?php echo $user_detail['pekerjaan_ibu']; ?>" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NAMA BAPA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="nama_bapa" value="<?php echo $user_detail['nama_bapa']; ?>" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NO TEL BAPA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="no_tel_bapa" value="<?php echo $user_detail['no_tel_bapa']; ?>" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">PEKERJAAN BAPA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="pekerjaan_bapa" value="<?php echo $user_detail['pekerjaan_bapa']; ?>" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NAMA DIHUBUNGI UNTUK KECEMASAN</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="nama_kecemasan" value="<?php echo $user_detail['nama_kecemasan']; ?>" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NO TEL UNTUK KECEMASAN</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="no_kecemasan" value="<?php echo $user_detail['no_kecemasan']; ?>" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">KELAS</label>
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
        
        
        <?php
        $query = $this->db->query("SELECT uacc_id, fullname FROM view_user_list WHERE user_status='active'");
        $list_all_teacher = $query->result_array();
        ?>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NAMA GURU KELAS</label>
            <div class="col-md-9">
                <select class="form-control select2me input-xlarge" id="guru_kelas_uacc_id">
                    <option></option>
                    <?php foreach($list_all_teacher as $a => $b){ ?>
                    <option value="<?php echo $b['uacc_id']; ?>" <?php if($user_detail['guru_kelas_uacc_id'] == $b['uacc_id']){ echo "selected"; } ?>><?php echo $b['fullname']; ?></option>
                    <?php } ?>
                </select>
                
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        
        <div class="form-group">
            <label class="col-md-3 control-label">TARIKH TAMAT TASKA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge date-picker" id="tarikh_tamat_taska" value="<?php echo $user_detail['tarikh_tamat_taska']; ?>" />
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
    var mykid = $("#mykid").val();
    var address = $("#address").val();
    var date_of_birth = $("#date_of_birth").val();
    
    var tarikh_masuk_taska = $("#tarikh_masuk_taska").val();
    var nama_ibu = $("#nama_ibu").val();
    var no_tel_ibu = $("#no_tel_ibu").val();
    var pekerjaan_ibu = $("#pekerjaan_ibu").val();
    var nama_bapa = $("#nama_bapa").val();
    var no_tel_bapa = $("#no_tel_bapa").val();
    var pekerjaan_bapa = $("#pekerjaan_bapa").val();
    var nama_kecemasan = $("#nama_kecemasan").val();
    var no_kecemasan = $("#no_kecemasan").val();
    var tarikh_tamat_taska = $("#tarikh_tamat_taska").val();
    
    var guru_kelas_uacc_id = $("#guru_kelas_uacc_id").val();
    

    var user_status = $("#user_status").val();

    var user_department_id = $("#user_department_id").val();
    
    
    
    Metronic.blockUI({
        boxed: true,
        message: 'Sending data to server...'
    });
    $.ajax({
        url: '<?php echo base_url(); ?>users/admin_ajax_update_student',
        type: 'POST',
        dataType: 'json',
        data: { 
            postdata: { 
                uacc_id: '<?php echo $user_detail['uacc_id']; ?>',
                
                fullname: fullname,
                mykid: mykid,
                address: address,
                date_of_birth: date_of_birth,
                
                tarikh_masuk_taska: tarikh_masuk_taska,
                nama_ibu: nama_ibu,
                no_tel_ibu: no_tel_ibu,
                pekerjaan_ibu: pekerjaan_ibu,
                nama_bapa: nama_bapa,
                no_tel_bapa: no_tel_bapa,
                pekerjaan_bapa: pekerjaan_bapa,
                nama_kecemasan: nama_kecemasan,
                tarikh_tamat_taska: tarikh_tamat_taska,
                guru_kelas_uacc_id: guru_kelas_uacc_id,
                user_status: user_status,
                user_department_id: user_department_id
            } 
        },
        success: function(data){
            Metronic.unblockUI();
            if(data.status == "success"){
                swal({
                    title: "BERJAYA!",
                    text: "DATA PELAJAR TELAH DIKEMASKINI",
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
