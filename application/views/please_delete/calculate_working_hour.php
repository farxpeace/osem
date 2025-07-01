<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


<table class="table table-bordered table-responsive">
    <thead>
        <tr>
            <th>Title</th>
            <th>Clock in & out</th>
            <th>Prework</th>
            <th>Actual Work</th>
            <th>Overtime</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($scenario as $a => $b){ ?>
        <tr>
            <td>
                <?php echo $b['title']; ?>
            </td>
            <td>
                Clock In : <?php echo $b['clockin_dttm']; ?><br />
                Clock Out : <?php echo $b['clockout_dttm']; ?>
                </td>
            <td>
                Has Prework : <?php echo $b['has_prework']; ?><br />
                <?php if($b['has_prework'] == "yes"){ ?>
                     Start : <?php echo $b['prework_start_dttm']; ?><br />
                     End : <?php echo $b['prework_end_dttm']; ?><br />
                     Hours : <?php echo $b['calculate_prework']['prework_hour']; ?> (<?php echo $b['calculate_prework']['nice_date']; ?>)<br />
                     Rate : RM<?php echo $b['calculate_prework']['prework_rate']; ?> / hour<br />
                     Sum Pay : RM<?php echo $b['calculate_prework']['prework_sum_rate']; ?> Nett<br />
                <?php } ?>
            </td>
            <td>
                Has Work : <?php echo $b['has_work']; ?><br />
                <?php if($b['has_work'] == "yes"){ ?>
                     Start : <?php echo $b['work_start_dttm']; ?><br />
                     End : <?php echo $b['work_end_dttm']; ?><br />
                     Rate : RM<?php echo $b['work_rate_per_day'] ?><br />
                     Sum Rate : RM<?php echo $b['work_sum_rate'] ?><br />
                <?php } ?>

            </td>
            <td>
                Has Overtime : <?php echo $b['has_overtime']; ?><br />
                <?php if($b['has_overtime'] == "yes"){ ?>
                     Start : <?php echo $b['overtime_start_dttm']; ?><br />
                     End : <?php echo $b['overtime_end_dttm']; ?><br />
                     Hours : <?php echo $b['calculate_overtime']['overtime_hour']; ?> (<?php echo $b['calculate_overtime']['nice_date']; ?>)<br />
                     Rate : RM<?php echo $b['calculate_overtime']['overtime_rate']; ?> / hour<br />
                     Sum Pay : RM<?php echo $b['calculate_overtime']['overtime_sum_rate']; ?> Nett<br />
                <?php } ?>

            </td>
            <td>
                Prework : RM<?php echo $b['calculate_prework']['prework_sum_rate'] ?? 0; ?><br />
                Work : RM<?php echo $b['work_sum_rate'] ?? 0 ?><br />
                Overtime : RM<?php echo $b['calculate_overtime']['overtime_sum_rate'] ?? 0; ?><br /><br />

                Grand Total : RM<?php echo $b['calculate_grand_pay'] ?>

            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

