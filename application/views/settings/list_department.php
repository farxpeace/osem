<?php $this->load->view('includes/header'); ?>


<div class="clearfix" style="margin-bottom: 20px;">
    <a href="javascript: void(0);" onclick="javascript: modal_add_new_department();" class="btn green">
         TAMBAH KELAS <i class="fa fa-plus"></i>
    </a>
</div>
<div class="table-container">
    <table id="example" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>KELAS</th>
                
                <th>Actions<sup>(s)</sup></th>
            </tr>
        </thead>                             
    </table>
</div>
<div id="modal_add_new_department" class="modal fade" tabindex="-1" data-width="760">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">TAMBAH KELAS</h4>
    </div>
    <div class="modal-body" id="modal_body_add_new_department">
        <div class="row">
            <div class="col-md-12 form-horizontal">
                
                <div class="form-group">
                    <label class="col-md-3 control-label">NAMA KELAS</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="add_user_department_name" />
                        <span class="help-block error_message" style="display: none;"></span>
                    </div>
                </div>
                
                
                
                
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn red pull-left" data-dismiss="modal">TUTUP</button>
        <button type="button" onclick="javascript: btn_add_new_department();" class="btn green pull-right">HANTAR <i class="fa fa-arrow-right"></i></button>
    </div>
</div>

<div id="modal_edit_type" class="modal fade" tabindex="-1" data-width="760">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">UBAH KELAS</h4>
    </div>
    <div class="modal-body" id="modal_body_edit_type">
        <div class="row">
            <div class="col-md-12 form-horizontal">
                
                <div class="form-group">
                    <label class="col-md-3 control-label">NAMA KELAS</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="edit_user_department_name"/>
                        <span class="help-block error_message" style="display: none;"></span>
                    </div>
                </div>
                
                
                
                
                
                <input hidden="" id="edit_user_department_id" />
                
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn red pull-left" data-dismiss="modal">TUTUP</button>
        <button type="button" onclick="javascript: btn_edit_type();" class="btn green pull-right">HANTAR <i class="fa fa-arrow-right"></i></button>
    </div>
</div>

<?php $this->load->view('includes/footer'); ?>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/global/scripts/datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/table-ajax.js"></script>



<script type="text/javascript">
function quick_edit(user_department_id){
    
    Metronic.blockUI({
        boxed: true,
        message: 'Loading data from server...'
    });
    
    
    $.ajax({
        url: "<?php echo base_url(); ?>settings/ajax_admin_get_department",
        type: "POST",
        dataType: "JSON",
        data: {
            postdata: {
               user_department_id: user_department_id
            }
        },
        success: function(data){
            
            Metronic.unblockUI();
            $("#edit_user_department_id").val(data.user_department_id);
            $("#edit_user_department_name").val(data.user_department_name);
            
            $("#modal_edit_type").modal("show");

            
        }
    })
}
</script>
<script type="text/javascript">
function modal_add_new_department(){
    $("#modal_add_new_department").modal("show");
    
}
</script>
<script type="text/javascript">
var datatable_el;
$(function(){
    
    $('#modal_add_new_department').on('shown.bs.modal', function() {
        $("#tg_name").focus();
    })
    
    datatable_el = $('#example').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url(); ?>settings/ajax_dt_list_department",
            "type": "POST"
        },
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
        "columns": [
            { "data": "user_department_id" },
            { "data": "user_department_name" },
            { "data": "user_department_id", "render": function ( data, type, row ) {
                redited = '';
                //redited += '<a href="javascript: void(0);" onclick="javascript: quick_edit_section1(\''+row.el_id+'\');" class="btn btn-xs green"><i class="fa fa-pencil"></i></a>';
                redited += '<a href="javascript: void(0);" onclick="javascript: quick_delete(\''+row.user_department_id+'\');" class="btn btn-xs red"><i class="fa fa-times"></i></a>'
                redited += '<a href="javascript: void(0);" onclick="javascript: quick_edit(\''+row.user_department_id+'\');" class="btn btn-xs blue"><i class="fa fa-pencil"></i></a>'
                return redited
            } },
        ],
        "order": [0, 'desc']
    } );

})
</script>

<script type="text/javascript">
function quick_delete(user_department_id){
    swal({
        title: "ADAKAH ANDA PASTI?",
        text: "TINDAKAN INI TIDAK BOLEH DIULANG SEMULA",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "YA, PADAMKAN",
        cancelButtonText: "TUTUP",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
    function(){
        
        $.ajax({
            url: "<?php echo base_url(); ?>settings/ajax_admin_delete_department",
            type: "POST",
            dataType: "json",
            data: {
                postdata: {
                   user_department_id: user_department_id
                }
            },
            success: function(data){
                if(data.status == "success"){
                    datatable_el.ajax.reload(function(){
                        swal("BERJAYA!", "KELAS TELAH DIPADAMKAN", "success");
                    });
                } else {
                    sweetAlert("Oops...", "Something went wrong!", "error");
                }
            }
        })
        
        
    });
}
</script>


<script type="text/javascript">
function btn_add_new_department(){
    var error_el;
    $(".has-error").removeClass('has-error');
    $(".error_message").hide();
    
    
    var add_user_department_name = $("#add_user_department_name").val();
    var add_user_department_head_uacc_id = $("#add_user_department_head_uacc_id").val();
    
    
    
    Metronic.blockUI({
        target: "#modal_add_new_department",
        boxed: true,
        message: 'Sending data to server...'
    });
    
    $.ajax({
        url: '<?php echo base_url(); ?>settings/ajax_admin_add_new_department',
        type: 'POST',
        dataType: 'json',
        data: { 
            postdata: { 
                add_user_department_name: add_user_department_name,
                add_user_department_head_uacc_id: add_user_department_head_uacc_id
            } 
        },
        success: function(data){
            Metronic.unblockUI("#modal_add_new_department");
            if(data.status == "success"){
                
                swal({
                    title: "BERJAYA!",
                    text: "KELAS BARU TELAH BERJAYA DITAMBAH",
                    type: "success",
                    closeOnConfirm: true
                },
                function(){
                    //$("#modal_add_new_state").modal("hide");
                    Metronic.blockUI({
                        target: "#modal_add_new_department",
                        boxed: true,
                        message: 'Reloading data...'
                    });
                    datatable_el.ajax.reload(function(){
                        Metronic.unblockUI("#modal_add_new_department");
                        $("#modal_add_new_department").modal("hide");
                        $("#tg_name").val("");
                    });
                    //window.location = "<?php echo base_url(); ?>order/view/"+data.invoice_number;
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
function btn_edit_type(){
    var error_el;
    $(".has-error").removeClass('has-error');
    $(".error_message").hide();
    
    var edit_user_department_name = $("#edit_user_department_name").val();
    var edit_ob_scope_of_work_registration_number = $("#edit_ob_scope_of_work_registration_number").val();
    var edit_user_department_id = $("#edit_user_department_id").val();
    
    Metronic.blockUI({
        target: "#modal_edit_type",
        boxed: true,
        message: 'Saving data to server...'
    });
    
    $.ajax({
        url: '<?php echo base_url(); ?>settings/ajax_admin_edit_department',
        type: 'POST',
        dataType: 'json',
        data: { 
            postdata: { 
                edit_user_department_name: edit_user_department_name,
                edit_ob_scope_of_work_registration_number: edit_ob_scope_of_work_registration_number,
                edit_user_department_id: edit_user_department_id
            } 
        },
        success: function(data){
            Metronic.unblockUI("#modal_edit_type");
            if(data.status == "success"){
                
                swal({
                    title: "BERJAYA!",
                    text: "KELAS BERJAYA DIUBAH",
                    type: "success",
                    closeOnConfirm: true
                },
                function(){
                    //$("#modal_add_new_state").modal("hide");
                    Metronic.blockUI({
                        target: "#modal_edit_type",
                        boxed: true,
                        message: 'Reloading data...'
                    });
                    datatable_el.ajax.reload(function(){
                        Metronic.unblockUI("#modal_edit_type");
                        $("#modal_edit_type").modal("hide");
                        
                    });
                    //window.location = "<?php echo base_url(); ?>order/view/"+data.invoice_number;
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

</script>
<script type="text/javascript">
$(function(){
    
})
</script>