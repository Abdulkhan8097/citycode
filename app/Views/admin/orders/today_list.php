 
<div class="app-content bg-img my-10 my-md-10">
    <div class="side-app">
<h3 class="page-title">List Orders</h3>
        <div class="row ">
            <div>
                <div class="col-12">
                 <?php echo view('admin/_topmessage'); ?>
                 </div>
                <div class="card">
                    
                    
                    <div class="table-responsive">
                        <form class="card" id='add_member_form' method='get' action="<?php echo site_url('orders'); ?>" enctype='multipart/form-data'> 
                            <table class="table card-table table-vcenter text-nowrap ">
                                    
                                    <tbody>
                                            <tr>
                                                    <td width="30%">
                                                        <div class="col-sm-6 col-md-6 float-left"> 
                                                            <input type="text" name="txtsearch" value="<?php echo isset($searchArray['txtsearch']) ? $searchArray['txtsearch'] : ''?>"  class="form-control" placeholder="Search by order no, pnr,mobile nos">
                                                        </div>
                                                        <div class="col-sm-3 col-md-3 float-left">
                                                        
                                                            <button type="submit" class="btn btn-secondary mb-1" >Search</button>
                                                        </div>
                                                        
                                                    </td>
                                                    <td><a href="<?php echo site_url('neworder'); ?>"><button type="button" class="btn btn-success mb-1">New Ticket</button></a></td>
                                            </tr>
                                            
                                    </tbody>
                            </table>
                        </form>
                        

                    </div>
                    

                    
                    <div class="table-responsive">
                        <table class="table table-hover card-table table-striped table-vcenter table-outline text-nowrap">
                            <thead>
                                <tr class="heading-success">
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="S. No.">S. No.</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="Ticket No">Order No</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="Ticket No">PNR No</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="Customer Nmae">Cutomer Name</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="Phone">Phone</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="Train Number">Train Number</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="Train Class">Train Class</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="From Station">From Station</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="To Station">To Station</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="Bording">Bording</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="Tatkal">Tatkal</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="Advance Amount">Advance Amount</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="Ticket Amount">Ticket Amount</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="Jurnet Date">Jurney Date</th>
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="Order Date">Order Date</th>
                                    
                                    <th data-toggle="tooltip" data-placement="top"  data-original-title="action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                           
                            <?php foreach($ordersData as $kdata){ ?>
                                <tr>                                    
                                    <td><?php echo ++$startLimit; ?></td>
                                   
                                    <td><?php echo $kdata->orderno ; ?>
                                    <td><?php echo $kdata->pnrno ; ?>
                                    <td><?php echo $kdata->customername ; ?>
                                    <td><?php echo $kdata->customerphone; ?></td>
                                    <td><?php echo $kdata->trainid.", ".$kdata->train2.", ".$kdata->train3; ?></td>
                                    <td><?php echo $kdata->trainclassid; ?></td>
                                    <td><?php echo $kdata->fromstation; ?></td>
                                    <td><?php echo $kdata->tostation; ?></td>
                                    <td><?php echo $kdata->bording; ?></td>
                                    <td><?php echo $kdata->tatkal; ?></td>
                                    <td><?php echo $kdata->advamount; ?></td>
                                    <td><?php echo $kdata->ticketamount ; ?></td>
                                    <td><?php echo $kdata->jurneydate ; ?></td>
                                    <td><?php echo $kdata->orderdate ; ?></td>
                                   
                                    
                                    
                                    <td>
                                            <a href="<?php echo site_url('editorder?orderno=' . $kdata->orderno."&".'transactionno=' . $kdata->transactioncount) ?>" class='btn btn-secondary btn-sm'><i class="fa fa-edit"></i>Edit</a>

                                            <a href="" data-toggle="modal" data-target="#viewmodal_<?php echo $kdata->id; ?>" class='btn btn-secondary btn-sm'><i class="fa fa-eye"></i>View</a>

                                            <a href="<?php echo site_url('delorder?id=' . $kdata->id) ?>"  id="<?php echo $kdata->id; ?>" class='btn btn-danger btn-sm delete_profile' onclick="return confirm('Are you sure?')" ><i class="fa fa-trash"></i> Delete</a>

                                    <?php  echo view('admin/orders/_order_info', array('modelid' => "viewmodal_" . $kdata->id, 'arrOrderdetail' => $kdata)); ?>

                                        </td>
                                    
                                    
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                        <?php if ($pagination['haveToPaginate']) { ?>
                        <br>
                        <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'orders', 'varExtra' => $searchArray)); ?>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
   
</div>
 
<script>


  function change_st_status(stid)
  {
      var cur_status = $("#st_status"+stid).prop('checked');
      var next_status = cur_status ? 1 :0;

      $.ajax({
                type: "POST",
                url: "<?php echo site_url('changestatus'); ?>",
                data: 'id='+stid+"&st_status="+next_status,

                success: function (data) {                    
                    var objJson = JSON.parse(data);                   
                   // alert(objJson.txtstatus);
                },
                error: function () {
                    //  alert('error handing here');
                }
            });
       

            return false;

  }


  function close_st_status(stid)
  {
      var cur_status = $("#st_close_status"+stid).prop('checked');
      var next_status = cur_status ? 0 :1;

      $.ajax({
                type: "POST",
                url: "<?php echo site_url('changeclosestatus'); ?>",
                data: 'id='+stid+"&st_status="+next_status,

                success: function (data) {
                    var objJson = JSON.parse(data);
                   // alert(objJson.txtstatus);
                },
                error: function () {
                    //  alert('error handing here');
                }
            });


            return false;

  }


  function getOrder()
  {
      $.ajax({
                type: "POST",
                url: "<?php echo site_url('getorderAjax'); ?>",
                data: '',
                //dataType: "json",
//                beforeSend: function() {
//                    $("#loginerr_message").fadeOut(1000);
//                    $("#loginsucc_message").fadeOut(1000);
//                },
                success: function (data) {
                    //alert(data);
                    var objJson = JSON.parse(data);
                    var totalpnl =0;
                   
                    var changes;
                    for (var key in objJson) {
                        /** assign qty*/ 
                        totalpnl += parseFloat(objJson[key].pnl);
                        
                     //   var gtotalpnl = totalpnl.toFixed(2);

                        $('#rmqty'+objJson[key].id).html(objJson[key].remaining_qty);
                        $('#curpr'+objJson[key].id).html(objJson[key].current_price);
                        $('#prcchange'+objJson[key].id).html(objJson[key].percentage_change_price);
                        $('#prcchange'+objJson[key].id).removeClass();
                        if(objJson[key].percentage_change_price >0)
                          {
                              $('#prcchange'+objJson[key].id).addClass('text-green');
                          }
                          else
                              {
                                  $('#prcchange'+objJson[key].id).addClass('text-red');
                              }

                         $('#pnl'+objJson[key].id).html(objJson[key].pnl);
                        $('#pnl'+objJson[key].id).removeClass();
                        if(objJson[key].pnl >0)
                          {
                              $('#pnl'+objJson[key].id).addClass('badgetext badge badge-success badge-pill');
                          }
                          else
                              {
                                  $('#pnl'+objJson[key].id).addClass('badgetext badge badge-danger badge-pill');
                              }
                        $('#st'+objJson[key].id).html(objJson[key].stop_loss);
                        var trStatus = objJson[key].target_status ==1 ? '<span class="dot-label bg-primary" title="Completed" style="cursor: pointer;"></span>' : '<span class="dot-label bg-success" title="Pending" style="cursor: pointer;"></span>';
                        $('#tr_status'+objJson[key].id).removeClass();
                        if(objJson[key].target_status==1)
                            {
                                $('#tr_status'+objJson[key].id).addClass('text-red');
                            }
                            else
                                {
                                    $('#tr_status'+objJson[key].id).addClass('text-green');
                                }

                        $('#tr_status'+objJson[key].id).html(trStatus);
                        $('#tr1'+objJson[key].id).html(objJson[key].target_one+"("+objJson[key].target_one_qty+")");
                        $('#tr2'+objJson[key].id).html(objJson[key].target_two+"("+objJson[key].target_two_qty+")");
                        $('#tr3'+objJson[key].id).html(objJson[key].target_three+"("+objJson[key].target_three_qty+")");
                    }
                    var  gtotalpnl = totalpnl.toFixed(2);
                     $('#tpnl').html(gtotalpnl);

                    if(gtotalpnl > 0)
                        {
                            $('#tpnl').addClass('badgetext badge badge-success badge-pill');
                        }
                        else
                         {
                             $('#tpnl').addClass('badgetext badge badge-danger badge-pill');
                         }
                    

                   // alert(gtotalpnl);

                },
                error: function () {
                    //  alert('error handing here');
                }
            });
            return false;

  }

function load_this_page()
{
    window.location.reload();
}
 window.onload = function() {getOrder();}
var dt = new Date();
var timehour = dt.getHours();
//alert(timehour);
if(timehour >=9 && timehour <=23)
{
  setInterval("getOrder()",2000); // this will call every 2 secons

  setInterval("load_this_page()",15 * 60 *1000); // this will call after 15 mints
}

</script>

