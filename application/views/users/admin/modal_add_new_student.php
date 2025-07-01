<div class="row">
    <div class="col-md-12 form-horizontal">
        
        
        <div class="form-group">
            <label class="col-md-3 control-label">USERNAME</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" placeholder="Example : sara_dianne" id="uacc_username" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">PASSWORD</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="uacc_raw_password" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NAMA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" placeholder="Example : Alex Yong" id="fullname" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NO MYKID</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" placeholder="Contoh : 861112235841" id="mykid" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">ALAMAT</label>
            <div class="col-md-9">
                <textarea class="form-control input-xlarge" rows="3" id="address"></textarea>
                
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">TARIKH LAHIR</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge date-picker" id="date_of_birth" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">TARIKH MASUK TASKA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge date-picker" id="tarikh_masuk_taska" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NAMA IBU</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" placeholder="Contoh : Fara Nurazrin" id="nama_ibu" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NO TEL IBU</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="no_tel_ibu" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">PEKERJAAN IBU</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="pekerjaan_ibu" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NAMA BAPA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" placeholder="Contoh : Fara Nurazrin" id="nama_bapa" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NO TEL BAPA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="no_tel_bapa" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">PEKERJAAN BAPA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="pekerjaan_bapa" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        <hr />
        
        <div class="form-group">
            <label class="col-md-3 control-label">NAMA DIHUBUNGI UNTUK KECEMASAN</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="nama_kecemasan" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">NO TEL UNTUK KECEMASAN</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge" id="no_kecemasan" />
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">KELAS</label>
            <div class="col-md-9">
                <select class="form-control select2me input-xlarge" id="user_department_id">
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
                <select class="form-control input-xlarge select2me" id="user_status">
                    <option value="active">AKTIF</option>
                    <option value="inactive">TIDAK AKTIF</option>
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
                    <option value="<?php echo $b['uacc_id']; ?>"><?php echo $b['fullname']; ?></option>
                    <?php } ?>
                </select>
                
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">TARIKH TAMAT TASKA</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-xlarge date-picker" id="tarikh_tamat_taska" />
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
    
    var uacc_username = $("#uacc_username").val();
    var uacc_raw_password = $("#uacc_raw_password").val();
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


    blockUI();
    $.ajax({
        url: '<?php echo base_url(); ?>users/ajax_admin_create_new_student',
        type: 'POST',
        dataType: 'json',
        data: { 
            postdata: { 
                uacc_username: uacc_username,
                uacc_raw_password: uacc_raw_password,
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
                no_kecemasan: no_kecemasan,
                tarikh_tamat_taska: tarikh_tamat_taska,
                
                guru_kelas_uacc_id: guru_kelas_uacc_id,
                
                
                user_status: user_status,
                user_department_id: user_department_id,

            } 
        },
        success: function(data){
            $.unblockUI();
            if(data.status == "success"){
                swal({
                    title: "Berjaya!",
                    text: "Pelajar baru telah berjaya ditambah",
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
    $("#fullname").val("TEST "+fullname);
    $("#uacc_username").val((fullname.replace(/\s/g,'')).toLowerCase());
    $("#mykid").val(chance.integer({min: 111111111111, max: 999999999999}));
    $("#uacc_raw_password").val("12345678");
    $("#address").val(chance.address());
    
    $("#nama_ibu").val("IBU "+chance.name({ nationality: 'en' }));
    $("#no_tel_ibu").val(chance.integer({min: 100000000, max: 999999999}));
    $("#pekerjaan_ibu").val(chance.word({ syllables: 3 }));
    
    $("#nama_bapa").val("BAPA "+chance.name({ nationality: 'en' }));
    $("#no_tel_bapa").val(chance.integer({min: 100000000, max: 999999999}));
    $("#pekerjaan_bapa").val(chance.word({ syllables: 3 }));
    
    $("#nama_kecemasan").val("KECEMASAN "+chance.name({ nationality: 'en' }));
    $("#no_kecemasan").val(chance.integer({min: 100000000, max: 999999999}));
    
    var pic_email = "test_"+chance.integer({min: 100000000, max: 999999999})+"@skf.com.my";
    $("#uacc_email").val(pic_email);

}
</script>