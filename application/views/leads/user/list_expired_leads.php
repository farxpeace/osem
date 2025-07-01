<?php $this->load->view('includes/tfpay_header'); ?>
<style>
    .bottom-navigation-bar_stack {
        margin: 0 auto;
        padding-top: 10px;
        padding-bottom: 10px;
        bottom: 60px;
        background: transparent;
        box-shadow: inherit;
    }
</style>
<div class="header mb-1 is-fixed col-12 col-xs-6 col-md-4 offset-md-4 col-lg-6 col-xl-6">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">

            <h3>Expired Leads</h3>
        </div>
    </div>
</div>
<div id="app-wrap">
    <div class="row mt-3 me-1 ms-1" style="margin-bottom: 100px;">
        <div class="col-12">
            <?php if(count($list_all_leads) > 0){ ?>
                <?php foreach($list_all_leads as $a => $b){ ?>
                    <div class="card card-bordered">
                        <div class="card-inner-group">
                            <div class="card-inner">
                                <div class="project">
                                    <div class="project-head">
                                        <a href="#" class="project-title">
                                            <div class="user-avatar sq bg-purple"><span><?php echo $this->far_helper->makeInitialsFromSingleWord($b['company_name']) ?></span></div>
                                            <div class="project-info">
                                                <h6 class="title" style="margin-bottom: 2px !important;"><?php echo $b['company_name'] ?></h6>
                                                <span class="sub-text"><?php echo $b['pic_name'] ?></span>
                                            </div>
                                        </a>

                                    </div>
                                    <div class="project-details">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="btn-group btn-block">
                                                    <a href="tel:+<?php echo $b['pic_mobile'] ?>" type="button" class="btn btn-outline-primary"><?php echo $b['pic_mobile'] ?></a>
                                                    <a href="mailto:<?php echo $b['pic_email'] ?>" type="button" class="btn btn-outline-primary"><?php echo $b['pic_email'] ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="project-progress">
                                        <div class="project-progress-details">

                                            <div class="project-progress-percent"><?php echo $b['countdown_percentage'] ?>% from expired date.</div>
                                        </div>
                                        <div class="progress progress-pill progress-md bg-danger">
                                            <div class="progress-bar" data-progress="<?php echo $b['countdown_percentage'] ?>" style="width: <?php echo $b['countdown_percentage'] ?>%; background-color: #0ac968; border-top-left-radius: 0; border-bottom-left-radius: 0;"></div>

                                        </div>
                                    </div>
                                    <ul class="team-info">
                                        <li><span>Countdown</span><span class="badge badge-dim bg-danger" style="padding: 3px 12px !important"><span style="font-size: 0.9rem;"><?php echo $b['countdown_days'] ?> Days Left</span></span></li>
                                        <li><span>Expired Date</span><span class="badge badge-dim bg-danger" style="padding: 3px 12px !important"><span style="font-size: 0.9rem;"><?php echo $this->far_date->convert_format($b['expired_dttm'], 'l, j F Y') ?></span></span></li>
                                        <li>
                                            <span>Status</span>
                                            <span><span class="badge bg-info" style="color: #FFFFFF; font-size: 14px;"><?php echo $b['status_text'] ?></span></span>
                                        </li>
                                    </ul>
                                    <div class="project-meta">



                                    </div>
                                </div>
                            </div>
                            <div class="card-inner card-inner-md">
                                <h4 class="product-title" style="text-align: center;">Booth Details</h4>
                                <ul class="team-statistics">
                                    <li><span>RM<?php echo $this->far_helper->number_format_short($b['booth_price_single']); ?></span><span>Price</span></li>
                                    <li><span><?php echo $b['booth_count'] ?></span><span>Booth<sup>(s)</sup></span></li>
                                    <li><span>RM<?php echo $this->far_helper->number_format_short($b['booth_price_total']); ?></span><span>Total Price</span></li>
                                </ul>

                            </div>
                            <div class="card-inner card-inner-md">
                                <h4 class="product-title" style="text-align: center;">Sponsor Details</h4>
                                <ul class="team-statistics">
                                    <li><span>RM<?php echo $this->far_helper->number_format_short($b['sponsor_amount']); ?></span><span>Amount</span></li>
                                    <li><span><?php echo $b['sponsor_title'] ?></span><span>Title</span></li>
                                </ul>

                            </div>

                            <div class="card-inner card-inner-md">
                                <h4 class="product-title" style="text-align: center;">Extend / Assign</h4>
                                <div class="form_extend">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Agent</label>
                                                <span class="form-note">Specify the name of agent</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="form-control-select">
                                                        <select class="form-control assigned_agent_uacc_id">
                                                            <option value="0">Select Agent</option>
                                                            <?php foreach($this->far_agent->list_all_agent() as $c => $d){ ?>
                                                                <option value="<?php echo $d['uacc_id'] ?>"><?php echo $d['fullname'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-1 align-center">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Expired Days</label>
                                                <span class="form-note">Specify the expired date</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="form-control-select">
                                                        <select class="form-control extend_days">
                                                            <option value="0">Select Days</option>
                                                            <option value="1">1 days</option>
                                                            <option value="3">3 days</option>
                                                            <option value="7">7 days</option>
                                                            <option value="14">14 days</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="team-info">
                                    <li><span>Agent</span><span style="padding: 3px 12px !important" class="text_extend_assigned_agent_fullname">Please select Agent</span></li>
                                    <li><span>Expired Date</span><span class="text_extend_days" style="padding: 3px 12px !important"></span></li>
                                    <li>
                                        <button onclick="extend_this_lead(this,'<?php echo $b['lead_id'] ?>')" class="btn btn-primary mt-3">Extend this lead</button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                <?php } ?>
            <?php }else{ ?>
                <div class="alert alert-pro alert-info">
                    <div class="alert-text">
                        <h6>No expired leads</h6>
                        <p>Expired leads will appear here </p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>



    <div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
        <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
            <a href="javascript: void(0);" onclick="javascript: navigate_to('/auth_admin/dashboard/');" id="btn-popup-up" class="tf-btn accent large"><i class="fa-solid fa-angle-left"></i> Back to Dashboard</a>
        </div>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>

<script>
    function extend_this_lead(ele, lead_id){
        var parent = $(ele).closest('.card-inner');
        var assigned_agent_uacc_id = $(parent).find('.assigned_agent_uacc_id').val();
        var extend_days = $(parent).find('.extend_days').val();

        Swal.fire({

            title: "Confirmation",
            html: "Extend this leads ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirmed!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                blockUI();
                $.ajax({
                    url: '<?php echo base_url(); ?>leads/ajax_assign_extend_lead',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        postdata: {
                            lead_id: lead_id,
                            assigned_agent_uacc_id: assigned_agent_uacc_id,
                            extend_days: extend_days,
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == "success"){
                            swalTimer('success','Success', 'Lead added', 2000).then(
                                function(value) {
                                    window.location.href = "/leads/history/?lead_id="+lead_id;
                                },
                            );
                            if(data.redirect_url){
                                //blockUI();
                                setTimeout(function(){
                                    //window.top.location.href = data.redirect_url;
                                }, 2000);
                            }else{

                            }



                        }else{
                            var eell = data.errors;
                            $.each(eell, function(i,j){
                                var el_on_page = $("#"+i).length;
                                if (el_on_page){
                                    $("#"+i).closest('.form-group').addClass('has-error');

                                    if($("#"+i).closest('.form-group').find('.error_message')){
                                        $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                                    }else{
                                        $("#"+i).after('<span class="error_message">'+j+'</span>');
                                        $(".error_message").show();
                                    }

                                } else {
                                    //sweetAlert("Oops...", "Something went wrong!", "error");
                                }
                                console.log(i);
                                console.log(j)
                            });
                            Swal.fire({
                                icon: "error",
                                title: "Unable to Process!",
                                text: data.message_single
                            });


                        }


                    }
                });
            }
        });

    }
</script>

<script>
    $(function(){
        $(".assigned_agent_uacc_id, .extend_days").on("change", function(){
            onchange_extend(this);
        })
    })
    function onchange_extend(choosen){
        var parent = $(choosen).closest('.card-inner');
        console.log(parent)
        var select = $(parent).find('.assigned_agent_uacc_id');
        var assigned_agent_uacc_id = $(select).val();
        var extend_assigned_agent_fullname = $("option:selected", select).text()
        $(parent).find(".text_extend_assigned_agent_fullname").text(extend_assigned_agent_fullname);

        //extend days
        var selectdays = $(parent).find('.extend_days');
        var extend_days = $(selectdays).val();
        if(extend_days > 0){
            var someDate = new Date();
            var numberOfDaysToAdd = parseInt(extend_days);
            someDate.setDate(someDate.getDate() + numberOfDaysToAdd);

            var options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            var formattedDate = new Intl.DateTimeFormat('en-GB', options).format(someDate);

            console.log(formattedDate); // Example: "Wednesday, 25 June 2025"
            $(parent).find('.text_extend_days').text(formattedDate);
        } else {
            $(parent).find('.text_extend_days').text("Please choose days");
        }

    }
</script>

<script>
    $(function(){
        $("#lead_id").on("change", function(){
            onchange_lead_id();
        })
    });
    function onchange_lead_id(){
        var lead_id = $("#lead_id").val();

        blockUI_secondary();
        window.location.replace("/leads/history/?lead_id="+lead_id);
    }
</script>
