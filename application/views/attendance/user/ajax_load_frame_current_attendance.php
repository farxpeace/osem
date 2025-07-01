
<?php if(count($attendance_detail) < 3){ ?>
    <div class="alert alert-pro alert-primary">
        <div class="alert-text">
            <h6>Please clock-in for today</h6>
            <p>You haven't clock-in for today. Please clock-in so we can calculate your pay</p>
        </div>
    </div>
<?php }else{ ?>
    <?php if(strlen($attendance_detail['clockout_dttm'] ?? "") > 3){ ?>
        <div class="alert alert-pro alert-info">
            <div class="alert-text">
                <h6 style="text-align: center">Today attendance completed</h6>
                <div class="team">

                    <div class="user-card user-card-s2">

                        <div class="user-info" style="margin-top: 0px !important;">
                            <h6 style="font-size: 1.5rem !important;">RM <?php echo $attendance_detail['calculate_grand_pay'] ?></h6>
                            <span class="sub-text">Today pay</span>
                        </div>
                    </div>
                    <ul class="team-info">
                        <li><span>Preparation</span><span>RM <?php echo $attendance_detail['prework_sum_rate'] ?></span></li>
                        <li><span>Work</span><span>RM <?php echo $attendance_detail['work_sum_rate'] ?></span></li>
                        <li><span>Overtime</span><span>RM <?php echo $attendance_detail['overtime_sum_rate'] ?></span></li>
                    </ul>

                </div><!-- .team -->
            </div>
        </div>
    <?php }else{ ?>
        <div class="alert alert-pro alert-info fa-fade">
            <div class="alert-text">
                <h6>You already clock-in on <?php echo date("h:i A", strtotime($attendance_detail['clockin_dttm'])) ?></h6>
                <p>Dont forget to clock-out so we can calculate your pay.</p>
            </div>
        </div>
    <?php } ?>

<?php } ?>