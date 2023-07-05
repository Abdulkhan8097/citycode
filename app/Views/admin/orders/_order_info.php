<div class="modal fade" id="<?php echo $modelid; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $modelid; ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document">
            <form action="<?php echo site_url('orders/exitorder');?>">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title" id="<?php echo $modelid; ?>">Order Detail</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                </button>
                        </div>
                        <div class="modal-body">
                           
                            <table class="table card-table table-vcenter text-nowrap table-primary">
                                    
                                    <tbody>
                                            <tr>
                                                <td width="5%">Order No</td>
                                                   
                                                    <td>
                                                        <div class="col-sm-3 col-md-3 float-left"> 
                                                        <?php 
                                                        echo isset($arrOrderdetail->orderno) ? $arrOrderdetail->orderno :''; ?>
                                                        </div>
                                                        
                                                        
                                                    </td>
                                                    
                                                    <td width="5%">Transaction</td>
                                                    <td>
                                                    <div class="float-left">
                                                    <label class="form-label"></label>
                                                    
                                                     <?php  echo isset($arrOrderdetail->transactioncount) ? $arrOrderdetail->transactioncount:''; ?>
                                                        
                                                    
                                                    </div>
                                                    </td>
                                            </tr>
                                            <tr>
                                                 <td width="5%">Order Date</td>   
                                                    <td>
                                                    <div class="col-sm-6 col-md-6 float-left">
                                                        <?php 
                                                        echo isset($arrOrderdetail->orderdate) ? date('d-m-Y',strtotime($arrOrderdetail->orderdate)) :'';
                                                         ?>
                                                        </div>
                                                    </td>
                                                   
                                                    <td width="5%">Journey Date</td>
                                                    <td>
                                                    
                                                            <div class="input-group col-sm-10">
                                                                
                                                            <?php   echo isset($arrOrderdetail->jurneydate) ? date('d-m-Y',strtotime($arrOrderdetail->jurneydate)) :'' ?>
                                                            <?php   (isset($arrOrderdetail->jurneydate2) && $arrOrderdetail->jurneydate2 !='0000-00-00 00:00:00')? ', '.date('d-m-Y',strtotime($arrOrderdetail->jurneydate2)) :'' ?>
                                                            <?php   echo (isset($arrOrderdetail->jurneydate3) && $arrOrderdetail->jurneydate2 !='0000-00-00 00:00:00') ? ', '.date('d-m-Y',strtotime($arrOrderdetail->jurneydate3)) :'' ?>
                                                        </div>
                                                    </td>
                                            </tr>
                                            <tr>
                                                 <td width="5%">Customer Name</td>   
                                                    <td>
                                                    <div class="col-sm-6 col-md-6 float-left">
                                                        <?php 
                                                         echo isset($arrOrderdetail->customername) ? $arrOrderdetail->customername : ''; ?>
                                                        </div>
                                                    </td>
                                                   
                                                    <td width="5%">Phone Number</td>
                                                    <td>
                                                    <div class="float-left">
                                                        <?php echo isset($arrOrderdetail->customerphone) ? $arrOrderdetail->customerphone :''; ?>
                                                        
                                                     </div>
                                                    </td>
                                            </tr>
                                            <tr>
                                                  <td width="5%">Train Number</td>  
                                                    <td>
                                                    <div class="col-sm-4 col-md-4 float-left">
                                                        
                                                        <?php echo isset($arrOrderdetail->trainid) ? $arrOrderdetail->trainid :''; ?>
                                                        <?php echo (isset($arrOrderdetail->train2) && $arrOrderdetail->train2) ? ', '.$arrOrderdetail->train2 :''; ?>
                                                        <?php echo (isset($arrOrderdetail->train3) && $arrOrderdetail->train2) ? ', '.$arrOrderdetail->train3 :''; ?>
                                                     </div>
                                                        
                                                        <div class="col-sm-8 col-md-8 float-left">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    Train Name: &nbsp;&nbsp;
                                                                </div>
                                                           <?php  echo isset($arrOrderdetail->trainname) ? $arrOrderdetail->trainname :''; ?>
                                                        </div>
                                                        
                                                     </div>
                                                    </td>
                                                    
                                                    <td width="5%">Advance</td>
                                                   
                                                    <td><div class=" float-left">
                                                        
                                                            <?php echo isset($arrOrderdetail->advamount)?$arrOrderdetail->advamount:''; ?>
                                                            
                                                     </div></td>
                                            </tr>
                                            <tr>
                                                   <td width="5%">From Station</td> 
                                                    <td>
                                                    <div class="col-sm-4 col-md-4 float-left">
                                                        <?php echo isset($arrOrderdetail->fromstation)?$arrOrderdetail->fromstation:''; ?>
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                       <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    To Station: &nbsp;
                                                                </div>
                                                           <?php echo isset($arrOrderdetail->tostation)?$arrOrderdetail->tostation:''; ?>
                                                        </div>
                                                     </div>
                                                        
                                                    </td>
                                                   <td width="5%">Class</td>
                                                    <td>
                                                        <label class="custom-control custom-checkbox">
                                                            <?php echo isset($arrOrderdetail->trainclassid) ? $arrOrderdetail->trainclassid:''; ?>
                                                        </label>
                                                    </td>
                                            </tr>
                                            
                                            <tr>
                                                   <td width="5%">Passanger No</td> 
                                                    <td>
                                                    <div class="col-sm-4 col-md-4 float-left">
                                                        <?php echo isset($arrOrderdetail->passangerno)?$arrOrderdetail->passangerno:''; ?>
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                       <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                     PNR: &nbsp;&nbsp;
                                                                </div>
                                                           <?php echo isset($arrOrderdetail->pnrno)?$arrOrderdetail->pnrno:''; ?>
                                                        </div>
                                                     </div>
                                                        
                                                    </td>
                                                   <td width="5%">Status</td>
                                                    <td>
                                                        <label class="custom-control custom-checkbox">
                                                            <?php echo isset($arrOrderdetail->status) ? $arrOrderdetail->status:''; ?>
                                                        </label>
                                                    </td>
                                            </tr>
                                            
                                            
                                            
                                    </tbody>
                            </table>
                        
                            
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                
                        </div>
                </div>
            </form>
        </div>
</div>