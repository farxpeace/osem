<?php $this->load->view('includes/header'); ?>


<!--
<div class="clearfix" style="margin-bottom: 20px;">
    <a href="javascript: void(0);" onclick="javascript: modal_add_new_designation();" class="btn green">
         Add New User Role <i class="fa fa-plus"></i>
    </a>
</div>
-->
<div class="table-container">
    <table id="example" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>USER ROLE</th>
                <th>Actions<sup>(s)</sup></th>
            </tr>
        </thead>                             
    </table>
</div>
<div id="modal_add_new_designation" class="modal fade" tabindex="-1" data-width="760">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">ADD NEW USER ROLE</h4>
    </div>
    <div class="modal-body" id="modal_body_add_new_designation">
        <div class="row">
            <div class="col-md-12 form-horizontal">
                
                <div class="form-group">
                    <label class="col-md-3 control-label">USER ROLE NAME</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Enter USER ROLE NAME" id="add_user_role_name" />
                        <span class="help-block error_message" style="display: none;"></span>
                    </div>
                </div>
                
                
                
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn red pull-left" data-dismiss="modal">Close</button>
        <button type="button" onclick="javascript: btn_add_new_designation();" class="btn green pull-right">Submit <i class="fa fa-arrow-right"></i></button>
    </div>
</div>

<div id="modal_edit_type" class="modal fade" tabindex="-1" data-width="760">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Edit mode</h4>
    </div>
    <div class="modal-body" id="modal_body_edit_type">
        <div class="row">
            <div class="col-md-12 form-horizontal">
                
                <div class="form-group">
                    <label class="col-md-3 control-label">NAME</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Enter NAME" id="edit_user_role_name"/>
                        <span class="help-block error_message" style="display: none;"></span>
                    </div>
                </div>
                
                
                
                <input hidden="" id="edit_user_role_id" />
                
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn red pull-left" data-dismiss="modal">Close</button>
        <button type="button" onclick="javascript: btn_edit_type();" class="btn green pull-right">Submit <i class="fa fa-arrow-right"></i></button>
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
function quick_edit(user_role_id){
    
    Metronic.blockUI({
        boxed: true,
        message: 'Loading data from server...'
    });
    
    
    $.ajax({
        url: "<?php echo base_url(); ?>settings/ajax_admin_get_designation",
        type: "POST",
        dataType: "JSON",
        data: {
            postdata: {
               user_role_id: user_role_id
            }
        },
        success: function(data){
            
            Metronic.unblockUI();
            $("#edit_user_role_id").val(data.user_role_id);
            $("#edit_user_role_name").val(data.user_role_name);
            
            $("#modal_edit_type").modal("show");

            
        }
    })
}
</script>
<script type="text/javascript">
function modal_add_new_designation(){
    $("#modal_add_new_designation").modal("show");
    
}
</script>
<script type="text/javascript">
var datatable_el;
$(function(){
    
    $('#modal_add_new_designation').on('shown.bs.modal', function() {
        $("#tg_name").focus();
    })
    
    datatable_el = $('#example').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url(); ?>settings/ajax_dt_list_user_role",
            "type": "POST"
        },
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
        "columns": [
            { "data": "user_role_id" },
            { "data": "user_role_name" },
            
            { "data": "user_role_id", "render": function ( data, type, row ) {
                redited = '';
                //redited += '<a href="javascript: void(0);" onclick="javascript: quick_edit_section1(\''+row.el_id+'\');" class="btn btn-xs green"><i class="fa fa-pencil"></i></a>';
                //redited += '<a href="javascript: void(0);" onclick="javascript: quick_delete(\''+row.user_role_id+'\');" class="btn btn-xs red"><i class="fa fa-times"></i></a>'
                //redited += '<a href="javascript: void(0);" onclick="javascript: quick_edit(\''+row.user_role_id+'\');" class="btn btn-xs blue"><i class="fa fa-pencil"></i></a>'
                return redited
            } },
        ],
        "order": [0, 'desc']
    } );

})
</script>

<script type="text/javascript">
function quick_delete(user_role_id){
    swal({
        title: "Are you sure?",
        text: "This action cannot be undone",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
    function(){
        
        $.ajax({
            url: "<?php echo base_url(); ?>settings/ajax_admin_delete_skf_user_role",
            type: "POST",
            dataType: "json",
            data: {
                postdata: {
                   user_role_id: user_role_id
                }
            },
            success: function(data){
                if(data.status == "success"){
                    datatable_el.ajax.reload(function(){
                        swal("Deleted!", "User Role has been deleted successfully", "success");
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
function btn_add_new_designation(){
    var error_el;
    $(".has-error").removeClass('has-error');
    $(".error_message").hide();
    
    
    var add_user_role_name = $("#add_user_role_name").val();
    
    
    
    Metronic.blockUI({
        target: "#modal_add_new_designation",
        boxed: true,
        message: 'Sending data to server...'
    });
    
    $.ajax({
        url: '<?php echo base_url(); ?>settings/ajax_admin_add_new_skf_user_role',
        type: 'POST',
        dataType: 'json',
        data: { 
            postdata: { 
                add_user_role_name: add_user_role_name
            } 
        },
        success: function(data){
            Metronic.unblockUI("#modal_add_new_designation");
            if(data.status == "success"){
                
                swal({
                    title: "Success!",
                    text: "New User Role has been added",
                    type: "success",
                    closeOnConfirm: true
                },
                function(){
                    //$("#modal_add_new_state").modal("hide");
                    Metronic.blockUI({
                        target: "#modal_add_new_designation",
                        boxed: true,
                        message: 'Reloading data...'
                    });
                    datatable_el.ajax.reload(function(){
                        Metronic.unblockUI("#modal_add_new_designation");
                        $("#modal_add_new_designation").modal("hide");
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
    
    var edit_user_role_name = $("#edit_user_role_name").val();
    var edit_ob_scope_of_work_registration_number = $("#edit_ob_scope_of_work_registration_number").val();
    var edit_user_role_id = $("#edit_user_role_id").val();
    
    Metronic.blockUI({
        target: "#modal_edit_type",
        boxed: true,
        message: 'Saving data to server...'
    });
    
    $.ajax({
        url: '<?php echo base_url(); ?>settings/ajax_admin_edit_designation',
        type: 'POST',
        dataType: 'json',
        data: { 
            postdata: { 
                edit_user_role_name: edit_user_role_name,
                edit_ob_scope_of_work_registration_number: edit_ob_scope_of_work_registration_number,
                edit_user_role_id: edit_user_role_id
            } 
        },
        success: function(data){
            Metronic.unblockUI("#modal_edit_type");
            if(data.status == "success"){
                
                swal({
                    title: "Success!",
                    text: "Designation successfully updated",
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