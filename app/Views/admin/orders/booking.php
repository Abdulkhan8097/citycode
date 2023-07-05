<?php helper('form'); ?>
<div class="app-content bg-img my-3 my-md-5">
    <div class="side-app">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                 <?php echo view('admin/_topmessage'); ?>
                <div>
                <form class="card" id='add_member_form' method='post' action="<?php echo site_url('updatebooking'); ?>" enctype='multipart/form-data'>    
                    <div>
                   <?php echo \Config\Services::validation()->listErrors(); ?>
                    <?php echo csrf_field() ?>
                    <?php 
                    $data = array( 'type'  => 'hidden','name'  => 'newtransaction', 'id'    => 'newtransaction');
                    echo form_input($data,''); ?>
                        
                    <div class="table-responsive">
                        <label class="form-label">  &nbsp;Booking Order Details</label>
                            <table class="table card-table table-vcenter text-nowrap table-primary">
                                    
                                    <tbody>
                                            <tr>
                                                <td width="5%">Order No</td>
                                                   
                                                    <td>
                                                        <div class="col-sm-3 col-md-3 float-left"> 
                                                        <?php 
                                                        $arrData = array('name'=>'orderno','id'=>"orderno",'type'=>'number','class'=>'form-control','placeholder'=>"Order No");
                                                        echo form_input($arrData,isset($arrOrderdetail['orderno']) ? $arrOrderdetail['orderno'] :''); ?>
                                                        </div>
                                                        <div class="col-sm-3 col-md-3 float-left">
                                                        
                                                            <button type="button" class="btn btn-secondary mb-1" onclick="javascript:tbnsearch();">Search</button>
                                                        </div>
                                                        
                                                    </td>
                                                    
                                                    <td width="5%">Transaction</td>
                                                    <td>
                                                    <div class="float-left">
                                                    <label class="form-label"></label>
                                                    
                                                     <?php 
                                                        $arrExtra = array('id'=>"transaction",'class'=>'form-control select2 custom-select','data-placeholder'=>"Choose one");
                                                        echo form_dropdown('transaction',$arrTransaction, isset($arrOrderdetail['transactioncount']) ? $arrOrderdetail['transactioncount']:'',$arrExtra); ?>
                                                        
                                                    
                                                    </div>
                                                    </td>
                                            </tr>
                                            <tr>
                                                 <td width="5%">Order Date</td>   
                                                    <td>
                                                    <div class="col-sm-6 col-md-6 float-left">
                                                        <?php 
                                                        echo isset($arrOrderdetail['orderdate']) ? date('d-m-Y',strtotime($arrOrderdetail['orderdate'])) :'';
                                                         ?>
                                                        </div>
                                                    </td>
                                                   
                                                    <td width="5%">Journey Date</td>
                                                    <td>
                                                    
                                                            <div class="input-group col-sm-10">
                                                                
                                                            <?php   echo isset($arrOrderdetail['jurneydate']) ? date('d-m-Y',strtotime($arrOrderdetail['jurneydate'])) :'' ?>
                                                            <?php   (isset($arrOrderdetail['jurneydate2']) && $arrOrderdetail['jurneydate2'] !='0000-00-00 00:00:00')? ', '.date('d-m-Y',strtotime($arrOrderdetail['jurneydate2'])) :'' ?>
                                                            <?php   echo (isset($arrOrderdetail['jurneydate3']) && $arrOrderdetail['jurneydate2'] !='0000-00-00 00:00:00') ? ', '.date('d-m-Y',strtotime($arrOrderdetail['jurneydate3'])) :'' ?>
                                                        </div>
                                                    </td>
                                            </tr>
                                            <tr>
                                                 <td width="5%">Customer Name</td>   
                                                    <td>
                                                    <div class="col-sm-6 col-md-6 float-left">
                                                        <?php 
                                                         echo isset($arrOrderdetail['customername']) ? $arrOrderdetail['customername'] : ''; ?>
                                                        </div>
                                                    </td>
                                                   
                                                    <td width="5%">Phone Number</td>
                                                    <td>
                                                    <div class="float-left">
                                                        <?php echo isset($arrOrderdetail['customerphone']) ? $arrOrderdetail['customerphone'] :''; ?>
                                                        
                                                     </div>
                                                    </td>
                                            </tr>
                                            <tr>
                                                  <td width="5%">Train Number</td>  
                                                    <td>
                                                    <div class="col-sm-4 col-md-4 float-left">
                                                        
                                                        <?php echo isset($arrOrderdetail['trainid']) ? $arrOrderdetail['trainid'] :''; ?>
                                                        <?php echo (isset($arrOrderdetail['train2']) && $arrOrderdetail['train2']) ? ', '.$arrOrderdetail['train2'] :''; ?>
                                                        <?php echo (isset($arrOrderdetail['train3']) && $arrOrderdetail['train2']) ? ', '.$arrOrderdetail['train3'] :''; ?>
                                                     </div>
                                                        
                                                        <div class="col-sm-8 col-md-8 float-left">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    Train Name: &nbsp;&nbsp;
                                                                </div>
                                                           <?php  echo isset($arrOrderdetail['trainname']) ? $arrOrderdetail['trainname'] :''; ?>
                                                        </div>
                                                        
                                                     </div>
                                                    </td>
                                                    
                                                    <td width="5%">Advance</td>
                                                   
                                                    <td><div class=" float-left">
                                                        
                                                            <?php echo isset($arrOrderdetail['advamount'])?$arrOrderdetail['advamount']:''; ?>
                                                            
                                                     </div></td>
                                            </tr>
                                            <tr>
                                                   <td width="5%">From Station</td> 
                                                    <td>
                                                    <div class="col-sm-4 col-md-4 float-left">
                                                        <?php echo isset($arrOrderdetail['fromstation'])?$arrOrderdetail['fromstation']:''; ?>
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                       <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    To Station: &nbsp;&nbsp;
                                                                </div>
                                                           <?php echo isset($arrOrderdetail['tostation'])?$arrOrderdetail['tostation']:''; ?>
                                                        </div>
                                                     </div>
                                                        
                                                    </td>
                                                   <td width="5%">Class</td>
                                                    <td>
                                                        <label class="custom-control custom-checkbox">
                                                            <?php echo isset($arrOrderdetail['trainclassid']) ? $arrOrderdetail['trainclassid']:''; ?>
                                                        </label>
                                                    </td>
                                            </tr>
                                            
                                            <tr>
                                                   <td width="5%">Passanger No</td> 
                                                    <td>
                                                    <div class="col-sm-4 col-md-4 float-left">
                                                        <?php echo isset($arrOrderdetail['passangerno'])?$arrOrderdetail['passangerno']:''; ?>
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                       <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    Cancel Charge: &nbsp;&nbsp;
                                                                </div>
                                                           <?php echo isset($arrOrderdetail['cancelcharge'])?$arrOrderdetail['cancelcharge']:''; ?>
                                                        </div>
                                                     </div>
                                                        
                                                    </td>
                                                   <td width="5%">Cancel Making Charge</td>
                                                    <td>
                                                        <label class="custom-control custom-checkbox">
                                                            <?php echo isset($arrOrderdetail['cancelmakingcharge']) ? $arrOrderdetail['cancelmakingcharge']:''; ?>
                                                        </label>
                                                    </td>
                                            </tr>
                                            
                                            
                                            
                                    </tbody>
                            </table>
                        
                        <label class="form-label">  &nbsp;BOOKING DETAILS</label>
                          <table class="table card-table table-vcenter text-nowrap table-warning">
                                        
                                        <tbody>
                                            
                                                <tr>
                                                        
                                                        <td  width="10%">PNR</td>
                                                        <td>
                                                          <div class="col-sm-6 col-md-6 float-left">   <?php 
                                                        $arrData = array('name'=>'pnrno','id'=>"pnrno",'type'=>'text','class'=>'form-control','placeholder'=>"PNR No");
                                                        echo form_input($arrData,isset($arrOrderdetail['pnrno']) ? $arrOrderdetail['pnrno'] :''); ?>
                                                          </div>
                                                        </td>
                                                        <td width="10%">Status</td>
                                                        <td>
                                                          <div class="col-sm-6 col-md-6 float-left">   
                                                            <?php 
                                                            $arrExtra = array('id'=>"status",'class'=>'form-control select2 custom-select','data-placeholder'=>"Choose one");
                                                            echo form_dropdown('status',$arrOrderstatus, isset($arrOrderdetail['status']) ? $arrOrderdetail['status']:'',$arrExtra); ?>
                                                          </div>
                                                          </td>
                                                        
                                                </tr>
                                                <tr> 
                                                        <td >Ticket Amount </td>
                                                        <td>
                                                            <div class="col-sm-6 col-md-6 float-left"> 
                                                            <?php 
                                                                $arrData = array('name'=>'ticketamount','id'=>"ticketamount",'type'=>'text','class'=>'form-control','placeholder'=>"Order No");
                                                                echo form_input($arrData,isset($arrOrderdetail['ticketamount']) ? $arrOrderdetail['ticketamount'] :''); ?>
                                                            </div>
                                                            </td>
                                                            
                                                            <td >Booking Date </td>
                                                        <td>
                                                            <div class="col-sm-6 col-md-6 float-left"> 
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                                        </div>
                                                                </div><input class="form-control" value="<?php echo isset($arrOrderdetail['bookingdate']) ? date('Y-m-d',strtotime($arrOrderdetail['bookingdate'])) :''?>" placeholder="DD/MM/YYYY" type="date" name="booking_date" id="journey_date" >
                                                        </div>
                                                            </div>
                                                            </td>
                                                </tr>
                                                
                                                <tr> 
                                                        <td >Service Charge </td>
                                                        <td>
                                                            <div class="col-sm-6 col-md-6 float-left"> 
                                                            <?php 
                                                                $arrData = array('name'=>'servicecharge','id'=>"servicecharge",'type'=>'text','class'=>'form-control','placeholder'=>"Service Charge");
                                                                echo form_input($arrData,isset($arrOrderdetail['servicecharge']) ? $arrOrderdetail['servicecharge'] :''); ?>
                                                            </div>
                                                            </td>
                                                            
                                                            <td >Making Charge </td>
                                                        <td>
                                                            <div class="col-sm-6 col-md-6 float-left"> 
                                                            <?php 
                                                                $arrData = array('name'=>'makingcharge','id'=>"makingcharge",'type'=>'text','class'=>'form-control','placeholder'=>"Making Charge");
                                                                echo form_input($arrData,isset($arrOrderdetail['makingcharge']) ? $arrOrderdetail['makingcharge'] :''); ?>
                                                            </div>
                                                            </td>
                                                </tr>
                                                
                                                <tr> 
                                                        <td >Ticket Type </td>
                                                        <td>
                                                            <div class="col-sm-6 col-md-6 float-left"> 
                                                            <?php 
                                                        $arrExtra = array('id'=>"tickettypeid",'class'=>'form-control select2 custom-select','data-placeholder'=>"Choose one");
                                                        echo form_dropdown('tickettypeid',$arrTickettype, isset($arrOrderdetail['tickettypeid'])?$arrOrderdetail['tickettypeid']:'',$arrExtra); ?>
                                                            </div>
                                                            </td>
                                                            
                                                            <td >Internet ID </td>
                                                        <td>
                                                            <div class="col-sm-6 col-md-6 float-left"> 
                                                            <?php 
                                                        $arrExtra = array('id'=>"internetid",'class'=>'form-control select2 custom-select','data-placeholder'=>"Choose one");
                                                        echo form_dropdown('internetid',$arrInternetuserlist, isset($arrOrderdetail['internetid'])?$arrOrderdetail['internetid']:'',$arrExtra); ?>
                                                            </div>
                                                            </td>
                                                </tr>
                                          
                                                 <tr>
                                                   <td width="5%">Bill Amount</td> 
                                                    <td>
                                                    <div class="col-sm-2 col-md-2 float-left">
                                                        <?php echo isset($arrOrderdetail['fromstation'])?$arrOrderdetail['fromstation']:''; ?>
                                                     </div>
                                                        <div class=" float-left">
                                                            <div class="input-group col-sm-6 col-md-10">
                                                            <label>Receive Amount: &nbsp;&nbsp;</label>
                                                           <?php 
                                                                $arrData = array('name'=>'finalrec','id'=>"finalrec",'type'=>'text','class'=>'form-control','placeholder'=>"Making Charge");
                                                                echo form_input($arrData,isset($arrOrderdetail['finalrec']) ? $arrOrderdetail['finalrec'] :''); ?>
                                                        </div>
                                                     </div>
                                                        
                                                    </td>
                                                   <td width="5%">Refund Amount </td>
                                                    <td>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                           <?php 
                                                                $arrData = array('name'=>'refundamount','id'=>"refundamount",'type'=>'text','class'=>'form-control','placeholder'=>"Making Charge");
                                                                echo form_input($arrData,isset($arrOrderdetail['refundamount']) ? $arrOrderdetail['refundamount'] :''); ?>
                                                        </div>
                                                        
                                                        <div class="col-sm-6 col-md-6 float-left">
                                                       <div class="input-group">
                                                           <label>  Billing Date:</label>
                                                                <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                                        </div>
                                                                </div><input class="form-control" value="<?php echo isset($arrOrderdetail['finaldate']) ? date('Y-m-d',strtotime($arrOrderdetail['finaldate'])) :''?>" placeholder="DD/MM/YYYY" type="date" name="finaldate" id="journey_date" >
                                                        </div>
                                                     </div>
                                                    </td>
                                            </tr>
                                                
                                                
                                        </tbody>
                                </table>
                            
                            
                            <table class="table card-table table-vcenter text-nowrap table-primary">
                                       
                                        <tbody>
                                                <tr>
                                                    <td width="10%">Information</td>  
                                                        <td >
                                                            <div class="col-sm-6 col-md-6 float-left"> 
                                                            <?php 
                                                        $arrData = array('name'=>'information','id'=>"information",'placeholder'=>"Information",'rows'=>"3",'class'=>'form-control');
                                                        echo form_textarea($arrData, isset($arrOrderdetail['info'])?$arrOrderdetail['info']:''); ?>
                                                            </div>  
                                                        </td>
                                                </tr>
                                                
                                        </tbody>
                                </table>

                    </div>
                    <!-- table-responsive -->
                    <?php if($orderno){ ?>
                        <div style=" padding-left: 100px; padding-bottom: 10px"> 
                         <?php 
                            $arrData = array('name'=>'Submit','class'=>'btn btn-success  btn-lg pull-left','style'=>"margin-left: 5px;");
                            echo form_submit($arrData,'Update'); ?>
                           </div>
                    <?php } ?>
                    </div>
                    
                    
                    
                    
                            </form>
                   
                </div>
            </div>
        </div>
    </div>

</div>
<script src="<?php echo base_url('js/jquery1.9.min.js'); ?>"></script>
<script type="text/javascript">
    
   
    function tbnsearch()
     {
         var orderid = document.getElementById('orderno').value;    
        var url= "<?php echo site_url('booking?orderno=');?>"+orderid;   
        //alert(url);   
        window.location.href=url;
     }
     
     
   $(document).ready(function(){
     
      $('#transaction').change(function() {  
        var trno = $('#transaction').val();   
        
        var orderid = document.getElementById('orderno').value;
        var url= "<?php echo site_url('booking?orderno=');?>"+orderid+"&transactionno="+trno;
        window.location.href=url;
    });
     
    
     
    });
    
</script>