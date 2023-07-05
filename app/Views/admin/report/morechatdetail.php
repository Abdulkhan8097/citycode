<?php foreach ($chatlist as $kdata) { ?>  

    <?php if ($kdata->send_by == 'company') { ?>                
        <li class="clearfix">
            <div class="chat-avatar w-sm">
                <span class="user-name font-weight-bold"><?php echo $kdata->branch_name; ?></span><br>

            </div>
            <div class="conversation-text">
                <div class="ctext-wrap">
                    <span class="user-name"><?php echo $kdata->created_date; ?></span>
                    <p>
                        <?php echo $kdata->msg; ?>
                    </p>
                </div>
            </div>
        </li>
    <?php } else if ($kdata->send_by == 'customer') { ?>

        <li class="clearfix odd">
            <div class="chat-avatar w-sm">
                <span class="user-name font-weight-bold"><?php echo $kdata->customer_name; ?></span>
                <span class="time"><?php //echo $kdata->created_date;  ?></span>
            </div>
            <div class="conversation-text">
                <div class="ctext-wrap">
                    <span class="user-name"><?php echo $kdata->created_date; ?></span>
                    <p>
                        <?php echo $kdata->msg; ?>
                    </p>
                </div>
            </div>
        </li>

    <?php } ?>
<?php } ?>