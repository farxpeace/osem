<?php $this->load->view('includes/header'); ?>
<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<style>
.facebook {
    background-color: #3b5998 !important;
}
.google {
    background-color: #d34836 !important;
}
.phonemobile {
    background-color: #00927e !important;
}

table#example thead tr th {
    text-transform: uppercase !important;
}

.round_picture {
    width:50px;
    height:50px;
    border-radius:50%;
    background-position: center;
    background-size:100% auto;
    background-repeat: no-repeat;
    border: 3px solid #e0e0e0;
    float: left;
}

.fit_content {
    white-space: nowrap !important;
}

.search_input_datatable {
    margin-left: 30px;
    float: left;
}
</style>


<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
        <a href="javascript:;" class="btn blue" onclick="open_modal_add_user();"><i class="fa fa-plus"></i> ADD USER </a>
    </div>
</div>



<div class="table-scrollable table-scrollable-borderless">

    

    <table id="example" class="table table-hover table-light">
        <thead>
            <tr>
                <th></th>
                <th>NAMA</th>
                <th>STATUS</th>
                
                
                <th>KELAS</th>
                
                
                <th>JAWATAN</th>
                <th>Actions<sup>(s)</sup></th>
            </tr>
        </thead>                             
    </table>
</div>




<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_new_user" data-width="760">
	<div class="modal-content">
        <div class="modal-header">
	       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       <h4 class="modal-title">TAMBAH GURU/KAKITANGAN</h4>
	   </div>
	   <div class="modal-body" id="modal_add_new_user_body" style="width: 100% !important">
        
	   </div>
       <div class="modal-footer wizard-footer height-wizard">
            <div class="pull-left">
                <button type="button" class="btn btn-danger" data-dismiss="modal">TUTUP</button>
    	   </div>
           <div class="pull-right">
                
                <button type="button" onclick="javascript: btn_click_submit();" class="btn green">HANTAR</button>
    	   </div>
	
	       <div class="clearfix"></div>
        </div>
            
    </div>
    
	<!-- /.modal-dialog -->
</div>


<?php $this->load->view('includes/footer'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<script type="text/javascript">
function open_modal_add_user(){
    blockUI();
    $("#modal_add_new_user_body").load("<?php echo base_url(); ?>users/modal_add_new_user", function(){
        $('#modal_add_new_user').modal({
            backdrop: 'static',
            keyboard: false
        });
        $.unblockUI()
    });
}
</script>

<script type="text/javascript">
var datatable_el;
$(function(){
    datatable_el = $('#example').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url(); ?>users/ajax_datatable_admin_list_all_user",
            "type": "POST"
        },
        "lengthMenu": [[10, 100, 200, -1], [10, 100, 200, "All"]],
        "columns": [
            { "data": "uacc_username", "className": "fit", "render": function ( data, type, row ) {
                html = "";
                html += '<div class="round_picture" style="background-image: url('+row.profile_picture+');"></div>';
                
                
                return html;
            } },
            { "data": "fullname", "searchable": "true" },
            { "data": "user_status", "searchable": "true" },
            { "data": "user_department_name", "searchable": "true" },
            { "data": "user_role_name", "searchable": "true" },
            
            { "data": "uacc_id", "render": function ( data, type, row ) {
                html = "";
                html += '<a href="javascript: void(0);" onclick="javascript: quick_delete(\''+row.uacc_id+'\');" class="btn btn-sm red"><i class="fa fa-times"></i> PADAM</a>';
                html += '<a href="<?php echo base_url(); ?>users/admin_view_user_detail/?page=user_profile&u='+row.uacc_id+'" class="btn btn-sm green"><i class="fa fa-search"></i> LIHAT</a>';
                
                html += '<a href="javascript: void(0);" onclick="javascript: force_change_password(\''+row.uacc_id+'\', \''+row.uacc_username+'\');" class="btn btn-sm blue"><i class="fa fa-times"></i> SET SEMULA KATA LALUAN</a>';
                return html
            } },

        ],
        "order": [2, 'desc'],
        dom: 'lBfrtip',
        buttons: [
            {
                text: 'Export Excel',
                action: function ( e, dt, node, config ) {
                    window.open("<?php echo base_url(); ?>export/excel_user_list", "_blank")
                }
            }
        ],
        "preDrawCallback": function( settings ) {
            $("#example_filter.dataTables_filter").addClass("search_input_datatable");
            $("#example_wrapper .dt-buttons").css("float", "right");
            $(".dataTables_length select").addClass('form-control input-xsmall input-inline');
            $(".dataTables_filter input").addClass('form-control input-small input-inline');
            //export buttons
            $(".dt-buttons .dt-button").addClass('btn blue')
        },
    } );
})
</script>
<script type="text/javascript">
function force_change_password(uacc_id, uacc_username){
    swal({
        title: "Are you sure?",
        html: true,
        text: "Reset password for user<br><b>"+uacc_username+"</b>",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, proceed!",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
    function(){
        $.ajax({
            url: "<?php echo base_url(); ?>users/ajax_admin_force_reset_password",
            type: "POST",
            dataType: "json",
            data: {
                postdata: {
                    uacc_id: uacc_id
                }
            },
            success: function(data){
                if(data.status == "success"){
                    datatable_el.ajax.reload(function(){
                        swal("Success!", data.message, "success");
                    });
                } else {
                    sweetAlert("Oops...", "Something went wrong!", "error");
                }
            }
        })
    });
}
function quick_delete(uacc_id){
    swal({
        title: "Adakah anda pasti?",
        text: "Tindakan ini tidak boleh diulang semula",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
    function(){
        $.ajax({
            url: "<?php echo base_url(); ?>users/ajax_admin_delete_user",
            type: "POST",
            dataType: "json",
            data: {
                postdata: {
                    uacc_id: uacc_id
                }
            },
            success: function(data){
                if(data.status == "success"){
                    datatable_el.ajax.reload(function(){
                        swal("BERJAYA!", "GURU / KAKITANGAN BERJAYA DIPADAMKAN", "success");
                    });
                } else {
                    sweetAlert("Oops...", "Something went wrong!", "error");
                }
            }
        })
    });
}
var titleCase = function(s) {
    if (!s) return;
    s = s.toLocaleLowerCase().split(" ");
    var ss = "";
    for(i in s) {
        ss += s[i].substr(0,1).toUpperCase() + s[i].substr(1);
        ss += " ";
    }
    return ss.trim();
}
</script>