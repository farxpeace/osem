<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Noto+Sans+Symbols:wght@100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    body {
        font-family: "Courier Prime", monospace;
    }
    pre {
        font-family: "Courier Prime", monospace;
    }
</style>

<div class="row mt-3 ms-3 me-3">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                Add Scenario <small>Table : attendance_scenario</small>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="mb-3">
                        <label for="basic-url" class="form-label">Clock-In</label>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" id="new_clockin_date" value="<?php echo date("Y-m-d"); ?>">
                            <span class="input-group-text"></span>
                            <input type="time" class="form-control" id="new_clockin_time" value="<?php echo date("H:i:s"); ?>">
                        </div>
                    </div>
                    <div>
                        <div class="form-text">Clock-In Date & Time</div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="mb-3">
                        <label for="basic-url" class="form-label">Clock-Out</label>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" id="new_clockout_date" value="<?php echo date("Y-m-d"); ?>">
                            <span class="input-group-text"></span>
                            <input type="time" class="form-control" id="new_clockout_time" value="<?php echo date('H:i:s', strtotime('+1 hours')); ?>">
                        </div>
                    </div>
                    <div>
                        <div class="form-text">If work hour more than this minutes, will add 1 hour into work hour</div>
                    </div>
                </li>
                <li class="list-group-item"><button type="button" onclick="add_new_scenario();" class="btn btn-primary">Add New Scenario</button></li>
            </ul>

        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                Attendance Timeline <small>Table : attendance_timeline</small>
            </div>
            <?php
            $query = $this->db->query("SELECT * FROM attendance_timeline ORDER BY sorting ASC");
            $list_attendance_timeline = $query->result_array();
            ?>
            <ol class="list-group list-group-numbered">
                <?php foreach($list_attendance_timeline as $a => $b){ ?>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"><?php echo $b['timeline_name'] ?></div>
                            <b>Start</b> : <?php echo $b['start_dttm'] ?>
                            <br>
                            <b>End &nbsp;</b> : <?php echo $b['end_dttm'] ?>
                            <br>
                            <b>Type&nbsp;</b> : <?php echo $b['pay_type'] ?>
                            <br>
                            <b>Pay &nbsp;</b> : <?php echo $b['pay_price'] ?>
                        </div>
                    </li>
                <?php } ?>

            </ol>
        </div>
    </div>
</div>

<div class="row mt-3 ms-3 me-3">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                Meta & Value <small>Table : far_meta</small>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Prep</label>
                                <div class="form-control-wrap">
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="prep_minimum_minutes_to_mark_as_eligible" value="<?php echo $this->far_meta->get_value('prep_minimum_minutes_to_mark_as_eligible') ?>">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">minutes</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-text">If Prep minutes less than this minutes, system will consider it as 0 hour and not eligible for Prep</div>
                            </div>


                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label class="form-label" for="full-name">Overtime</label>
                                <div class="form-control-wrap">
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="ot_minimum_minutes_to_mark_as_eligible" value="<?php echo $this->far_meta->get_value('ot_minimum_minutes_to_mark_as_eligible') ?>">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">minutes</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-text">If Overtime minutes less than this minutes, system will consider it as 0 hour and not eligible for Overtime</div>
                            </div>


                        </div>
                    </div>
                </li>
                <li class="list-group-item"><button type="button" onclick="update_meta();" class="btn btn-primary">Update Meta</button></li>
            </ul>
        </div>
    </div>
</div>

<div class="row mt-3 ms-3 me-3">
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>No</th>
                <th>Title</th>

                <th>Calculation</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 0; foreach($scenario as $a => $b){ ?>
                <tr>
                    <td><?php echo $no+1; ?>
                        <?php if(($b['database'] ?? "no") == "yes"){ ?>
                            <br>
                            <button class="btn btn-sm btn-danger" onclick="delete_scenario('<?php echo $b["attendance_scenario_id"] ?>')"><i class="fa-solid fa-xmark fa-shake" style="color: #ffffff;"></i></button>
                        <?php } ?>
                    </td>
                    <td><?php echo $b['title']; ?>
                        <br><br>
                        <?php echo $b['clockin_dttm'] ?>
                        <br>
                        <?php echo $b['clockout_dttm'] ?>
                    </td>

                    <td>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Eligibility</th>
                                    <th>Type</th>
                                    <th>Pay</th>
                                    <th>Work Hour</th>
                                    <th>Total Pay</th>
                                </tr>
                            </thead>
                            <?php foreach($b['processed'] as $c => $d){ ?>
                                <tr>
                                    <td><?php echo $d['timeline_name'] ?></td>
                                    <td><?php echo $d['is_eligible'] ? "✅" : "❌" ?></td>
                                    <td><?php echo $d['pay_type'] ?></td>
                                    <td><?php echo $d['pay_price'] ?></td>
                                    <td><?php echo $d['working_hours'] ?></td>
                                    <td><?php echo $d['total_pay'] ?></td>
                                </tr>
                            <?php } ?>

                        </table>
                    </td>
                </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function update_meta(){
        Swal.fire({
            title: "Are you sure?",
            text: "Update settings",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirm!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/please_delete/update_far_meta',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        postdata: {
                            shift_end: $("#shift_end").val(),
                            prep_minimum_minutes_to_mark_as_eligible: $("#prep_minimum_minutes_to_mark_as_eligible").val(),
                            ot_minimum_minutes_to_mark_as_eligible: $("#ot_minimum_minutes_to_mark_as_eligible").val(),
                            calm_period_late_checkin_minutes: $("#calm_period_late_checkin_minutes").val(),
                        }
                    },
                    success: function(data){
                        if(data.status == "success"){

                            let timerInterval;
                            Swal.fire({
                                title: "Auto close alert!",
                                html: "I will close in <b></b> milliseconds.",
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const timer = Swal.getPopup().querySelector("b");
                                    timerInterval = setInterval(() => {
                                        timer.textContent = `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.reload();
                                }
                            });
                        }
                    }

                })
            }
        });
    }
</script>
<script>
    function add_new_scenario(){
        Swal.fire({
            title: "Are you sure?",
            text: "Add New Scenario",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirm!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/please_delete/add_new_scenario',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        postdata: {
                            new_clockin_date: $("#new_clockin_date").val(),
                            new_clockin_time: $("#new_clockin_time").val(),

                            new_clockout_date: $("#new_clockout_date").val(),
                            new_clockout_time: $("#new_clockout_time").val(),
                        }
                    },
                    success: function(data){
                        if(data.status == "success"){

                            let timerInterval;
                            Swal.fire({
                                title: "Auto close alert!",
                                html: "I will close in <b></b> milliseconds.",
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const timer = Swal.getPopup().querySelector("b");
                                    timerInterval = setInterval(() => {
                                        timer.textContent = `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.reload();
                                }
                            });
                        }
                    }

                })
            }
        });
    }
</script>
<script>
    function delete_scenario(attendance_scenario_id){
        Swal.fire({
            title: "Are you sure?",
            text: "Delete scenario",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirm!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/please_delete/delete_scenario',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        postdata: {
                            attendance_scenario_id: attendance_scenario_id
                        }
                    },
                    success: function(data){
                        if(data.status == "success"){

                            let timerInterval;
                            Swal.fire({
                                title: "Auto close alert!",
                                html: "I will close in <b></b> milliseconds.",
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const timer = Swal.getPopup().querySelector("b");
                                    timerInterval = setInterval(() => {
                                        timer.textContent = `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.reload();
                                }
                            });
                        }
                    }

                })
            }
        });
    }
</script>