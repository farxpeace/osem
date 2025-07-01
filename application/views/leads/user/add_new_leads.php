<?php $this->load->view('includes/tfpay_header'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/css/intlTelInput.css">
<style>
    .iti-flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/img/flags.png");}
    @media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
        .iti-flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/img/flags@2x.png");}
    }
    .intl-tel-input {
        width: 100% !important;
    }
</style>
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
            <h3>Add New Lead</h3>
        </div>
    </div>
</div>
<div id="app-wrap">

    <div class="row mt-3 me-1 ms-1" style="margin-bottom: 100px;">
        <div class="col-12">


            <div class="group-input form-group">
                <label>Company Name</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control force_uppercase" placeholder="Company name here" id="company_name">
                </div>
                <span class="help-block error_message" style="display: none;"></span>
            </div>

            <div class="group-input form-group">
                <label>Company Registration Number</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control force_uppercase" placeholder="Company registration number here" id="company_registration_number">
                </div>
                <span class="help-block error_message" style="display: none;"></span>
            </div>

            <div class="group-input form-group">
                <label>Person In-Charge Name</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control force_uppercase" placeholder="PIC name here" id="pic_name">
                </div>
                <span class="help-block error_message" style="display: none;"></span>
            </div>

            <div class="group-input form-group">
                <label>Person In-Charge Phone</label>
                <div class="form-control-wrap">
                    <input type="tel" class="form-control force_uppercase" placeholder="PIC Mobile" id="pic_mobile">
                </div>
                <span class="help-block error_message" style="display: none;"></span>
            </div>

            <div class="group-input form-group">
                <label>Person In-Charge Email (optional)</label>
                <div class="form-control-wrap">
                    <input type="email" class="form-control" placeholder="PIC email here" id="pic_email">
                </div>
                <span class="help-block error_message" style="display: none;"></span>
            </div>
        </div>

        <div class="col-12 mt-5">
            <div class="card card-bordered card-full">
                <div class="card-inner-group">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title" style="margin-bottom: 0 !important;">Booth Details</h6>
                            </div>
                            <div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="enable_booth">
                                    <label class="custom-control-label" for="enable_booth">Enable Booth</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner card-inner-md" id="frame_number_of_booth">
                        <div class="form-group">
                            <label class="form-label">Number of booths</label>
                            <div class="form-control-wrap number-spinner-wrap">
                                <button class="btn btn-icon btn-danger number-spinner-btn number-minus" data-number="minus" style="width: 100px;"><em class="icon ni ni-minus"></em></button>
                                <input type="number" class="form-control number-spinner" id="booth_count" placeholder="number" value="1" min="1" max="20">
                                <button class="btn btn-icon btn-success number-spinner-btn number-plus" data-number="plus" style="width: 100px;"><em class="icon ni ni-plus"></em></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner card-inner-md" id="frame_booth_summary">
                        <ul class="team-statistics">
                            <li>
                                <span class="text_booth_price_total">RM 0</span>
                                <span style="font-size: 0.975rem;">Approximated Total Booth Price</span>
                                <span style="font-size: 0.775rem;">(Booth price may vary depending on location)</span>
                            </li>
                        </ul>
                        <input id="booth_price_total" type="hidden" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-5">
            <div class="card card-bordered card-full">
                <div class="card-inner-group">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title" style="margin-bottom: 0 !important;">Sponsor Details</h6>
                            </div>
                            <div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="enable_sponsor">
                                    <label class="custom-control-label" for="enable_sponsor">Enable Sponsor</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner card-inner-md" id="frame_choose_sponsor">
                        <div class="form-group">
                            <label class="form-label">Please choose sponsorship</label>
                            <div class="form-control-select">
                                <select class="form-control" id="sponsor_title">
                                    <option value="Main Sponsor" data-price="1800000">Main Sponsor - RM1.8M</option>
                                    <option value="Platinum Sponsor" data-price="880000">Platinum Sponsor - RM880k</option>
                                    <option value="Gold Sponsor" data-price="380000">Gold Sponsor - RM380k</option>
                                    <option value="Silver Sponsor" data-price="180000">Silver Sponsor - RM180k</option>
                                    <option value="Category Presenter" data-price="80000">Category Presenter - RM80k</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
        <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
            <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>auth_admin/dashboard/');" class="tf-btn accent large" style="width: 70px; padding: 5px;"><i class="fa-solid fa-angle-left"></i></a>
            <a href="javascript: void(0);" onclick="javascript: btn_click_submit_lead();" class="tf-btn accent large">Submit New Lead</a>
        </div>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/js/intlTelInput.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/js/utils.js"></script>
<script>
    $(function(){
        $("#pic_mobile").intlTelInput({
            onlyCountries: [
                "my",
                "sg",
                "au",
                "id",
                "th",
                "bn",
                "hk",
                "tw",
                "mo"
            ],
            preferredCountries: [
                "my",
                "id"
            ],
            separateDialCode: true
        });

        $('#company_registration_number').keypress(function (e) {
            var regex = new RegExp("^[a-zA-Z0-9/]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }

            e.preventDefault();
            return false;
        });
    });
</script>
<script>
    $(function(){
        $("#enable_booth").on("change", function(){
            onchange_enable_booth();
        });
        onchange_enable_booth();
        function onchange_enable_booth(){
            if($("#enable_booth").is(":checked")){
                $('#frame_number_of_booth,#frame_booth_summary').unblock();
            } else {
                $('div#frame_number_of_booth, #frame_booth_summary').block({
                    message: "Please enable booth",
                    css: { border: '0px solid #a00',backgroundColor: 'transparent', color: '#FFFFFF', fontSize: '16px' }
                });
            }
        }

        $("#enable_sponsor, #sponsor_title").on("change", function(){
            onchange_enable_sponsor();
        });
        onchange_enable_sponsor();
        function onchange_enable_sponsor(){
            if($("#enable_sponsor").is(":checked")){
                $('#frame_choose_sponsor').unblock();

                $('#enable_booth').prop('checked', true); $("#enable_booth").change();

                //free booth
                if($("#sponsor_title").val() == "Main Sponsor"){
                    $("#booth_count").val(8); onchange_booth_count();
                } else if($("#sponsor_title").val() == "Platinum Sponsor"){
                    $("#booth_count").val(4); onchange_booth_count();
                } else if($("#sponsor_title").val() == "Gold Sponsor"){
                    $("#booth_count").val(2); onchange_booth_count();
                } else if($("#sponsor_title").val() == "Silver Sponsor"){
                    $("#booth_count").val(2); onchange_booth_count();
                } else if($("#sponsor_title").val() == "Category Presenter"){
                    $("#booth_count").val(1); onchange_booth_count();
                }

            } else {
                $('#enable_booth').prop('checked', false); $("#enable_booth").change();
                $('div#frame_choose_sponsor').block({
                    message: "Please enable sponsor",
                    css: { border: '0px solid #a00',backgroundColor: 'transparent', color: '#FFFFFF', fontSize: '16px' }
                });


            }
        }
    })
</script>
<script>
    $(function(){
        $("#booth_count").on("change", function(){
            onchange_booth_count();
        });
        $(".number-spinner-btn").on("click", function(){
            onchange_booth_count();
        });
        onchange_booth_count();
    });

    function onchange_booth_count(){
        var booth_count =  $("#booth_count").val();
        var booth_price_single = parseInt('<?php echo $this->far_meta->get_value("booth_price_single"); ?>');
        var booth_price_total = parseInt(booth_price_single)*parseInt(booth_count);

        $("#booth_price_total").val(booth_price_total);

        let formattedMYR = booth_price_total.toLocaleString('ms-MY', {
            style: 'currency',
            currency: 'MYR'
        });

        $(".text_booth_price_total").text("from "+formattedMYR)
    }
</script>
<script>
    function btn_click_submit_lead(){
        var error_el;
        reset_form_error();
        var enable_booth = "no";
        if($("#enable_booth").is(":checked")){ enable_booth = "yes"; }

        var enable_sponsor = "no";
        if($("#enable_sponsor").is(":checked")){ enable_sponsor = "yes"; }

        var html = "Add new leads ?<br><br><div style='text-align: left'>";
        if(enable_booth == "yes"){
            html += 'Booth : ✅';
            html += '<br>Count : '+$("#booth_count").val();
            html += '<br>Price : RM <?php echo $this->far_meta->get_value("booth_price_single"); ?>';
            html += '<br>Total Price : RM '+$("#booth_price_total").val()
        }else{
            html += 'Booth : ❌';
        }

        if(enable_sponsor == "yes"){
            html += '<br><br>Sponsor : ✅';
            html += '<br>Title : '+$("#sponsor_title").val();
            html += '<br>Amount : RM '+$("#sponsor_title option:selected").data("price")
        }else{
            html += '<br><br>Sponsor : ❌';
        }


        html += '</div>';
        Swal.fire({
            title: "Confirmation",
            html: html,
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
                    url: '<?php echo base_url(); ?>leads/ajax_add_lead',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        postdata: {
                            company_name: $("#company_name").val(),
                            company_registration_number: $("#company_registration_number").val(),
                            pic_name: $("#pic_name").val(),
                            pic_mobile: $("#pic_mobile").intlTelInput("getNumber"),
                            pic_email: $("#pic_email").val(),

                            enable_booth: enable_booth,
                            booth_count: $("#booth_count").val(),
                            booth_price_single: '<?php echo $this->far_meta->get_value("booth_price_single"); ?>',
                            booth_price_total: $("#booth_price_total").val(),

                            enable_sponsor: enable_sponsor,
                            sponsor_title: $("#sponsor_title").val(),
                            sponsor_amount: $("#sponsor_title option:selected").data("price")
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == "success"){
                            swalTimer('success','Success', 'Lead added', 2000).then(
                                function(value) {
                                    window.location.href = "/leads/history/?lead_id="+data.lead_id;
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
