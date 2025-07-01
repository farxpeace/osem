<div class="row">
    <div class="col-md-12 form-horizontal">
        
        
        <div class="form-group">
            <label class="col-md-3 control-label">USERNAME</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" placeholder="Example : sara_dianne" id="add_uacc_username" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">PASSWORD</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="add_uacc_raw_password" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NAMA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" placeholder="Example : Alex Yong" id="add_fullname" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NO KAD PENGENALAN</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" placeholder="Contoh : 861112235841" id="add_nric" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">ALAMAT</label>
            <div class="col-md-9">
                <textarea class="form-control input-xlarge" rows="3" id="add_address"></textarea>
                
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">TARIKH LAHIR</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge date-picker" id="add_date_of_birth" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">TARIKH MASUK KERJA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge date-picker" id="add_start_working_date" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">JAWATAN</label>
            <div class="col-md-9">
                <select class="form-control select2me input-xlarge" id="add_user_role_id">
                    <option></option>
                    <?php foreach($list_all_user_role as $a => $b){ ?>
                    <option value="<?php echo $b['user_role_id']; ?>"><?php echo $b['user_role_name']; ?></option>
                    <?php } ?>
                </select>
                
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">KELAS MENGAJAR</label>
            <div class="col-md-9">
                <select class="form-control select2me input-xlarge" id="add_user_department_id">
                    <option></option>
                    <?php foreach($list_all_user_department as $a => $b){ ?>
                    <option value="<?php echo $b['user_department_id']; ?>"><?php echo $b['user_department_name']; ?></option>
                    <?php } ?>
                </select>
                
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">STATUS</label>
            <div class="col-md-9">
                <select class="form-control input-xlarge select2me" id="add_user_status">
                    <option value="active">AKTIF</option>
                    <option value="inactive">TIDAK AKTIF</option>
                </select>
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">TARIKH TAMAT KERJA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge date-picker" id="add_end_working_date" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        
        
        
        
    </div>
</div>

<script type="text/javascript">
$(function(){
    $('.select2me').select2({
        placeholder: "Select",
        allowClear: false
    });
    
    $('.date-picker').datepicker({
        orientation: "left",
        autoclose: true,
    });
})
</script>

<script type="text/javascript">
function btn_click_submit(){
    var error_el;
    $(".has-error").removeClass('has-error');
    $(".error_message").hide();
    
    var add_uacc_username = $("#add_uacc_username").val();
    var add_uacc_raw_password = $("#add_uacc_raw_password").val();
    var add_fullname = $("#add_fullname").val();
    var add_nric = $("#add_nric").val();
    var add_address = $("#add_address").val();
    var add_date_of_birth = $("#add_date_of_birth").val();
    var add_start_working_date = $("#add_start_working_date").val();
    var add_user_status = $("#add_user_status").val();
    var add_end_working_date = $("#add_end_working_date").val();
    var add_user_department_id = $("#add_user_department_id").val();
    var add_user_role_id = $("#add_user_role_id").val();

    blockUI();
    $.ajax({
        url: '<?php echo base_url(); ?>users/ajax_admin_create_new_user',
        type: 'POST',
        dataType: 'json',
        data: { 
            postdata: { 
                add_uacc_username: add_uacc_username,
                add_uacc_raw_password: add_uacc_raw_password,
                add_fullname: add_fullname,
                add_nric: add_nric,
                add_address: add_address,
                add_date_of_birth: add_date_of_birth,
                add_start_working_date: add_start_working_date,
                add_user_status: add_user_status,
                add_end_working_date: add_end_working_date,
                add_user_department_id: add_user_department_id,
                add_user_role_id: add_user_role_id
            } 
        },
        success: function(data){
            $.unblockUI();
            if(data.status == "success"){
                swal({
                    title: "BERJAYA!",
                    text: "GURU/KAKITANGAN TELAH DITAMBAH",
                    type: "success",
                    closeOnConfirm: true
                },
                function(){
                    blockUI();
                    datatable_el.ajax.reload(function(){
                        $("#modal_add_new_user").modal("hide");
                        $.unblockUI();
                    });
                    
                    //window.location = "<?php echo base_url(); ?>users/admin_view_agent_detail/?u="+data.agent_uacc_id+"&page=user_profile";
                });
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
var listener = new window.keypress.Listener();
$(function(){
    listener.sequence_combo("a s d", function() {

        generate_demo_data();
    }, true);
});
function generate_demo_data(){
    var fullname = chance.name({ nationality: 'en' })
    $("#add_fullname").val("TEST "+fullname);
    $("#add_uacc_username").val((fullname.replace(/\s/g,'')).toLowerCase());
    $("#add_nric").val(chance.integer({min: 111111111111, max: 999999999999}));
    $("#add_uacc_raw_password").val("12345678");
    $("#add_address").val(chance.address());
    
    var pic_email = "test_"+chance.integer({min: 100000000, max: 999999999})+"@skf.com.my";
    $("#add_uacc_email").val(pic_email);

}
</script>