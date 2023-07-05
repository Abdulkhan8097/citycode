<?php $session = session(); ?>
<style type="text/css">
    .table{
        width:36%!important;
    }
</style>

<div class="page-content">
    


        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4 class="font-size-20">Reports</h4>
                </div>
            </div>
        </div>



        <div class="container">
            <?php echo view('admin/report/_searchform'); ?>
            <!-- Tab panes -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <?php echo view('admin/_topmessage'); ?>
                        <div class="tab-content">
                            <div id="home" class="container tab-pane active">
                                <div class="card-body">
                                     <?php helper('text');
                                      if($pagination["getNbResults"] >0 ){ ?>

                                    <div class="table-responsive">
                                        <!-- (<?php //echo $totalpaidamount; ?>) -->
                                        
                                            <table data-toggle="table" data-striped="true" class="table table-striped table-centered table-nowrap mb-1">
                                                <thead>
                                                    <tr>
                                                         <th data-sortable="true">SI.<br>No.</th>    
                                                        <th data-sortable="true">Company<br>Name</th>
                                                        <th data-sortable="true">Branch<br>Name</th>
                                                        <th data-sortable="true"> Code</th>
                                                        <th data-sortable="true">Customer<br>Name</th>
                                                        <th data-sortable="true">Date & Time</th>
                                                        <th data-sortable="true">Total<br>Amount</th>
                                                        <th data-sortable="true">Save<br>Amount</th>
                                                        <th data-sortable="true">Paid<br>Amount </th>
                                                        <th data-sortable="true">Commission</th>
                                                        <th scope="col" width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    $save_amt = 0;
                                                    $save_amt = 0;
                                                    $paid_amt = 0;
                                                    $commision = 0;
                                                    foreach ($transactionsList as $kdata) {
                                                        $temp_amount = 0;
                                                        $temp_amount = $kdata->citycode_commission;
                                                        $total_amt = $total_amt + $temp_amount;
                                                        ?>
                                                        <tr id="tr<?php echo $kdata->od_id; ?>">
                                                            <th scope="row"><?php echo ++$startLimit ; ?></th>
                                                            <td><?php echo $kdata->company_name; ?></td>
                                                            <td><?php echo $kdata->branch_name; ?></td>
                                                            <td><?php echo $kdata->vip_code ? $kdata->vip_code : $kdata->city_code; ?></td>
                                                            <td><?php echo $kdata->name; ?></td>
                                                            <td><?php echo $kdata->created_date; ?></td>
                                                            <td><?php echo $kdata->od_totalamount; ?></td>
                                                            <td><?php echo $kdata->od_saveamount; ?></td>
                                                            <td><?php echo $kdata->od_paidamount; ?></td>
                                                            <td><?php echo $kdata->citycode_commission; ?></td>
                                                            <td>
<a href="<?php echo site_url('atransactionreportsedit?id='.$kdata->od_id);?>" class="btn btn-success btn-sm" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                                                <a  href="javascript:void(0);" class='btn btn-danger btn-sm delete_profile' onclick="delTransaction(<?php echo  $kdata->od_id; ?>);" ><i class="fa fa-trash"></i> Delete</a>
                                                            </td>
                                                            <?php $i+=$kdata->od_totalamount;?>
                                                            <?php $save_amt+=$kdata->od_saveamount;?>
                                                            <?php $paid_amt+=$kdata->od_paidamount;?>
                                                            <?php $commision+=$kdata->citycode_commission;?>
                                                        </tr>
                                            <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php if (!empty($pagination['haveToPaginate'])) { ?><br>
                                                <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => $pageurl, 'varExtra' => $searchArray)); ?>
                                            <?php }
                                         ?>
                                    </div>
                                    <?php }else{ ?>
                                    <?php echo view('admin/_noresult',array('noResult'=>array("description"=>"Please change search criteria and submit again"))); ?>
                                <?php } ?>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered m-top20">
                     <tbody>
                        <tr>
                           <th>Total Amount</th>
                           <td><span style="color:green;">OMR <?php echo $i; ?></span></td>
                        </tr>
                         <tr>
                           <th>Total Paid Amount</th>
                           <td><span style="color:green;">OMR <?php echo $paid_amt; ?></span></td>
                        </tr>
                        <tr>
                           <th>Total Save Amount</th>
                           <td><span style="color:green;">OMR <?php echo $save_amt; ?></span></td>
                        </tr>
                         
                          <tr>
                           <th>Total CityCode Commission</th>
                           <td><span style="color:green;">OMR <?php echo $commision; ?></span></td>
                        </tr>
                        
                         
                     </tbody>
                  </table>						
                        </div>
                    </div>
                </div>
            </div> 
        </div> 


</div>
<script>
    
    function delTransaction(id)
    {
        if(!confirm('Are you sure?'))
        {
            return;
        }
        $.ajax({
                   url: "<?php echo site_url('deltransaction?od_id='); ?>"+id,
                   method: "GET",
                   data: {},
                   success: function (data)
                   { 
                       $('#tr'+id).hide(1000);
                   }
               });
    }
    </script>



