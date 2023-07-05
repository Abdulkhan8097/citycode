
<div class="page-content">



    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-20">Chat Details</h4>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
                <div class="dropdown">
                    <a class="btn btn-secondary waves-effect waves-light" onclick="window.history.back();">
                        <i class="ion ion-md-arrow-back"></i> Back
                    </a>

                </div>
            </div>
        </div>
    </div>



    <div class="container">

        <!-- Tab panes -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <?php echo view('admin/_topmessage'); ?>
                    <div class="tab-content">
                        <div id="home" class="container tab-pane active">
                            <div class="card-body">
                                <?php if ($pagination["getNbResults"] > 0) { ?>

                                    <div class="card">
                                        <div class="card-body">

                                            <div class="chat-conversation">
                                                <ul class="conversation-list" data-simplebar="init" style="max-height: 367px;">
                                                    <div class="simplebar-wrapper" style="margin: 0px -10px;">
                                                        <div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div>
                                                        <div class="simplebar-mask">
                                                            <div class="simplebar-offset" style="right: -20px; bottom: 0px;">
                                                                <div class="simplebar-content-wrapper" style="height: auto; padding-right: 20px; padding-bottom: 0px; overflow: hidden scroll;">
                                                                    <div class="simplebar-content" style="padding: 0px 10px;" id="chatlist">
                                                                        
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
                                                                                        <span class="time"><?php //echo $kdata->created_date;   ?></span>
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
                                                                               
                                                                       
                                                                    </div>
                                                                    
                                                                    <div id="morechat"><a href="javascript::void(0);" id="lnkmore";> Load Old Chat </a></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="simplebar-placeholder" style="width: auto; height: 480px;"></div>

                                                    </div>
                                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                                        <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>

                                                    </div>
                                                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                                        <div class="simplebar-scrollbar" style="height: 292px; transform: translate3d(0px, 74px, 0px); display: block;"></div>

                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <?php echo view('admin/_noresult', array('noResult' => array("message" => "No Chat Found"))); ?>
                                <?php } ?>
                            </div>
                        </div>						



                    </div>
                </div>
            </div>
        </div> 
    </div> 


</div>

<script>
    $(document).ready(function () {
        var page= 1;
        $('#lnkmore').click(function () {
            page++;
            $.ajax({ 
                    url: "<?php echo site_url('ReportController/getmorechatDetail?sender_id='.$searchArray['sender_id'].'&receiver_id='.$searchArray['receiver_id']); ?>&page="+page,
                    method: "GET",
                    
                    success: function (data)
                    {
                        if(data)
                        {
                            $('#chatlist').append(data);
                        }
                        esle
                        {
                            $('#lnkmore').hide();
                        }
                        
                    }
                });
          });




    });

</script>