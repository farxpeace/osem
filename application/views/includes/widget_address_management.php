<style>
    #modal_address_dashboard_body {
        min-height: 20vh;
        transition: height 0.5s, height 0.5s;
    }
</style>
<script>
    function open_modal_address_dashboard(){
        blockUI_secondary();
        $("#modal_address_dashboard_body").load('<?php echo base_url(); ?>address_management/ajax_modal_address_dashboard', {
            postdata: {
                uacc_id: '<?php echo $logged_in["uacc_id"] ?? ""; ?>'
            }
        }, function(){
            unblockUI();
            $("#modal_address_dashboard").modal("show");
        })
    }
</script>
<script>
    function use_this_address(element){
        var address_frame = $(element).closest('.address_frame');
        var data = $(address_frame).data();
        $(".confirm_address_frame").show();
        $(".confirm_address_frame .address_line_1").text(data.address_line_1);
        $(".confirm_address_frame .address_line_2").text(data.address_line_2);
        $(".confirm_address_frame .postcode_area_location").text(data.area_name +", "+data.post_office+", "+data.state_code);
        $("#postcode_id").val(data.postcode_id);
        $("#user_address_id").val(data.user_address_id)
        $("#modal_address_dashboard").modal("hide");
    }
    function delete_this_address(element){
        var address_frame = $(element).closest('.address_frame');
        var data = $(address_frame).data();
        blockUI_secondary();
        $.ajax({
            url: "<?php echo base_url(); ?>address_management/ajax_delete_address",
            type: "POST",
            dataType: "JSON",
            data: {
                postdata: {
                    user_address_id: data.user_address_id
                }
            },
            success: function(dataReturn){
                if(dataReturn.status == "success"){
                    $("#modal_address_dashboard").modal("hide");
                    open_modal_address_dashboard();
                    unblockUI();
                }else{
                    unblockUI();
                    var eell = dataReturn.errors;
                    $.each(eell, function(i,j){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: j,
                        })
                    })
                }
            }
        })
    }
</script>
