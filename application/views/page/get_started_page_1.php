<?php $this->load->view('includes/tfpay_header'); ?>
<style>
    body {
        background-color: #007a34 !important;
    }
</style>
    <div class="nk-split nk-split-page nk-split-lg">

        <div class="nk-split-content nk-split-stretch bg-white p-5 d-flex justify-center align-center flex-column">

            <div class="wide-xs-fix">
                <form class="nk-stepper stepper-init is-alter" action="#" id="stepper-survey-v2">
                    <div class="nk-stepper-content">
                        <div class="nk-stepper-progress stepper-progress mb-4">
                            <div class="stepper-progress-count mb-2"></div>
                            <div class="progress progress-md">
                                <div class="progress-bar stepper-progress-bar"></div>
                            </div>
                        </div>
                        <div class="nk-stepper-steps stepper-steps">

                            <div class="nk-stepper-step">
                                <div class="nk-stepper-step-head mb-4">
                                    <h5 class="title" style="font-size: 1rem">Which sector are your working in?</h5>
                                </div>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <ul class="custom-control-group flex-column align-start">
                                                    <li>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" name="working_sector" id="sector_goverment" value="goverment" required>
                                                            <label class="custom-control-label" for="sector_goverment">Goverment Sector</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" name="working_sector" id="sector_private" value="private" required>
                                                            <label class="custom-control-label" for="sector_private">Private Sector</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" name="working_sector" id="sector_glc" value="glc" required>
                                                            <label class="custom-control-label" for="sector_glc">GLC</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" name="working_sector" id="sector_contractor" value="contractor" required>
                                                            <label class="custom-control-label" for="sector_contractor">Contractor</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-stepper-step">
                                <div class="nk-stepper-step-head mb-4">
                                    <h5 class="title" style="font-size: 1rem">Income information.</h5>
                                    <p>A little bit information for us to know about you.</p>
                                </div>
                                <div class="row g-4">

                                    <div class="col-12">
                                        <label class="form-label" for="sv1-asking-salary">Monthly income</label>
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">RM</span>
                                                </div>
                                                <input type="number" class="form-control" id="monthly_income" name="monthly_income" placeholder="2750.00" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="sv1-asking-salary">Monthly allowance</label>
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">RM</span>
                                                </div>
                                                <input type="number" class="form-control" id="monthly_allowance" name="monthly_allowance" placeholder="500.00" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-stepper-step">
                                <div class="nk-stepper-step-head mb-4">
                                    <h5 class="title" style="font-size: 1rem">Tell us about yourself</h5>
                                </div>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="sv1-first-name">Nickname</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="fullname" name="sv1-first-name" placeholder="Azhar" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="sv1-last-name">Date of birth</label>
                                            <div class="form-control-wrap">
                                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="sv1-email-address">Email Address</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">

                                        <ul class="row g-3">
                                            <li class="col-6">
                                                <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full no-control">
                                                    <input type="radio" class="custom-control-input" name="gender" id="gender_male" value="male" required>
                                                    <label class="custom-control-label options" for="gender_male">
                                                                <span class="d-flex flex-column text-center py-1 py-sm-2">
                                                                    <span class="icon-wrap xl">
                                                                        <img class="img" src="<?php echo base_url(); ?>assets/myloan/icon_male-256x256.png" alt="">
                                                                    </span>
                                                                    <span class="lead-text mb-1 mt-3">Male</span>
                                                                </span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="col-6">
                                                <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full no-control">
                                                    <input type="radio" class="custom-control-input" name="gender" id="gender_female" value="female" required>
                                                    <label class="custom-control-label options" for="gender_female">
                                                                <span class="d-flex flex-column text-center py-1 py-sm-2">
                                                                    <span class="icon-wrap xl">
                                                                        <img class="img" src="<?php echo base_url(); ?>assets/myloan/icon_female-256x256.png" alt="">
                                                                    </span>
                                                                    <span class="lead-text mb-1 mt-3">Female</span>
                                                                </span>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Upload Documents</label>
                                            <span class="form-note mb-2">( Files accepted: .pdf. doc/docx - Max file size: 190k for demo limit )</span>
                                            <div class="form-control-wrap">
                                                <div class="form-file">
                                                    <input type="file" multiple class="form-file-input" id="sv2-file-attachment">
                                                    <label class="form-file-label" for="sv2-file-attachment">Choose files....</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nk-stepper-pagination pt-4 gx-4 gy-2 stepper-pagination">
                            <li class="step-prev"><button class="btn btn-dim btn-primary">Back</button></li>
                            <li class="step-next"><button class="btn btn-primary">Continue</button></li>
                            <li class="step-submit"><button class="btn btn-primary">Submit</button></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div><!-- .nk-split-content -->
    </div><!-- .nk-split -->
<?php $this->load->view('includes/tfpay_footer'); ?>

<script src="<?php echo base_url(); ?>assets/jquery-malaysia-user-generator.js?time=<?php echo time(); ?>"></script>
<script>
    $(function(){
        generate_demo_user();
    })
    function generate_demo_user(){
        $.FaraUserGenerator.init({
            //gender: 'female',
            prepend_username: 'user_',
            //race: "indian",
            prepend_fullname: "TEST ",
            email_domain: 'crm.myloan.my'
        },function(output_data){
            console.log(output_data)
            $("#fullname").val(output_data.profile_information.fullname);
            $("#email").val(output_data.user_authentication.email);

            //choose sector
            var working_sector_array = [];
            $("input[name=working_sector]").each(function(){
                working_sector_array.push($(this).attr('id'))
            })
            const working_sector = working_sector_array[Math.floor(Math.random() * working_sector_array.length)];
            $("#"+working_sector).prop("checked", true);

            $("#monthly_income").val(Math.floor((Math.random() * 10000) + 1000))
            $("#monthly_allowance").val(Math.floor((Math.random() * 2000) + 1000))

        });
    }
</script>
