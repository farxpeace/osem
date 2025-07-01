<?php if(strlen($message_single ?? "") > 0){ ?>
    <div class="alert alert-fill alert-danger alert-icon mt-2">
        <em class="icon ni ni-cross-circle"></em> <?php echo $message_single; ?>
    </div>
    <script>
        $("#submit_new_attendance").addClass('d-none');
    </script>
<?php }else{ ?>
    <div class="team">

        <ul class="team-info">
            <li>
                <span>
                    <?php echo ($validation[0]['is_eligible'] == "1") ? "✅" : "❌" ?>
                    Prep</span><span>RM <?php echo $this->far_helper->convert_to_currency_format($validation[0]['total_pay']); ?></span></li>
            <li><span><?php echo ($validation[1]['is_eligible'] == "1") ? "✅" : "❌" ?> Work</span><span>RM <?php echo $this->far_helper->convert_to_currency_format($validation[1]['total_pay']) ?></span></li>
            <li><span><?php echo ($validation[2]['is_eligible'] == "1") ? "✅" : "❌" ?> Overtime</span><span>RM <?php echo $this->far_helper->convert_to_currency_format($validation[2]['total_pay']) ?></span></li>
        </ul>

    </div><!-- .team -->

    <script>
        $("#submit_new_attendance").removeClass('d-none');
    </script>
<?php } ?>