<?php helper('form'); ?>
<div class="app-content bg-img my-3 my-md-5">
    <div class="side-app">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                 <?php echo view('admin/_topmessage'); ?>
                <div>
                <form class="card" id='add_member_form' method='post' action="<?php echo site_url('updateorder'); ?>" enctype='multipart/form-data'>    
                    <div>
                   <?php echo \Config\Services::validation()->listErrors(); ?>
                    <?php echo csrf_field() ?>
                        
                     <?php 
                    $data = array( 'type'  => 'hidden','name'  => 'orderno', 'id'    => 'orderno');
                     echo form_hidden('orderno', $orderno); ?>
                    <?php 
                    $data = array( 'type'  => 'hidden','name'  => 'newtransaction', 'id'    => 'newtransaction');
                    echo form_input($data,''); ?>
                        
                    <div class="table-responsive">
                        <label class="form-label">  &nbsp;Update Order</label>
                            <table class="table card-table table-vcenter text-nowrap table-primary">
                                    
                                    <tbody>
                                            <tr>
                                                <td width="5%">Order No</td>
                                                   
                                                    <td>
                                                        <div class="col-sm-3 col-md-3 float-left"> 
                                                        <?php 
                                                        $arrData = array('name'=>'order_number','id'=>"order_number",'type'=>'number','class'=>'form-control','placeholder'=>"Order No");
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
                                                 <td width="5%">Customer Code</td>   
                                                    <td>
                                                    <div class="col-sm-6 col-md-6 float-left">
                                                        <?php 
                                                        $arrData = array('name'=>'customer_code','id'=>"customer_code",'type'=>'text','class'=>'form-control','placeholder'=>"Customer Code");
                                                        echo form_input($arrData, isset($arrOrderdetail['customercode'])?$arrOrderdetail['customercode']:''); ?>
                                                        </div>
                                                    </td>
                                                   
                                                    <td width="5%">Order Date</td>
                                                    <td>
                                                    
                                                            <div class="input-group col-sm-10">
                                                                <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                                        </div>
                                                                </div><input class="form-control" value="<?php echo isset($arrOrderdetail['orderdate']) ? date('Y-m-d',strtotime($arrOrderdetail['orderdate'])) : ''?>"  placeholder="DD-MM-YYYY" type="date"  name="booking_date" id="booking_date" required >
                                                        </div>
                                                    </td>
                                            </tr>
                                            <tr>
                                                 <td width="5%">Customer Name</td>   
                                                    <td>
                                                    <div class="col-sm-6 col-md-6 float-left">
                                                        <?php 
                                                        $arrData = array('name'=>'customer_name','id'=>"customer_name",'required'=>'','placeholder'=>"Customer Name",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData,isset($arrOrderdetail['customername']) ? $arrOrderdetail['customername'] : ''); ?>
                                                        </div>
                                                    </td>
                                                   
                                                    <td width="5%">Phone Number</td>
                                                    <td>
                                                    <div class="float-left">
                                                        <?php 
                                                        $arrData = array('name'=>'phone','id'=>"phone",'placeholder'=>"Phone number",'required'=>'','type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData, isset($arrOrderdetail['customerphone']) ? $arrOrderdetail['customerphone'] :''); ?>
                                                        
                                                     </div>
                                                    </td>
                                            </tr>
                                            <tr>
                                                  <td width="5%">Train Number</td>  
                                                    <td>
                                                    <div class="col-sm-4 col-md-4 float-left">
                                                        
                                                        <?php 
                                                        $arrData = array('name'=>'ticketorder_trainid','id'=>"ticketorder_trainid",'placeholder'=>"Train Number",'required'=>'','type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData, isset($arrOrderdetail['trainid']) ? $arrOrderdetail['trainid'] :''); ?>
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                       <?php 
                                                        $arrData = array('name'=>'ticketorder_trainid1','id'=>"ticketorder_trainid1",'placeholder'=>"Train Number",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData, isset($arrOrderdetail['train2']) ? $arrOrderdetail['train2'] :''); ?>
                                                         </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                        <?php 
                                                        $arrData = array('name'=>'ticketorder_trainid2','id'=>"ticketorder_trainid2",'placeholder'=>"Train Number",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData, isset($arrOrderdetail['train3']) ? $arrOrderdetail['train3'] :''); ?>
                                                     </div>
                                                    </td>
                                                    
                                                    <td width="5%">Train Name</td>
                                                   
                                                    <td><div class=" float-left">
                                                        
                                                            <?php 
                                                        $arrData = array('name'=>'ticketorder_trainname','id'=>"ticketorder_trainname",'placeholder'=>"Train Name",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData, isset($arrOrderdetail['trainname']) ? $arrOrderdetail['trainname'] :''); ?>
                                                            
                                                     </div></td>
                                            </tr>
                                            <tr>
                                                   <td width="5%">Journey Date</td> 
                                                    <td>
                                                    <div class="col-sm-4 col-md-4 float-left">
                                                        <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                                        </div>
                                                                </div><input class="form-control" value="<?php echo isset($arrOrderdetail['jurneydate']) ? date('Y-m-d',strtotime($arrOrderdetail['jurneydate'])) :''?>" placeholder="DD/MM/YYYY" type="date"  style="width:100px" name="journey_date" id="journey_date" required>
                                                        </div>
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                       <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                                        </div>
                                                                </div><input class="form-control " value="<?php echo isset($arrOrderdetail['jurneydate2']) ? date('Y-m-d',strtotime($arrOrderdetail['jurneydate2'])) :''?>" placeholder="DD/MM/YYYY" type="date" style="width:100px" name="journey_date1" id="journey_date1">
                                                        </div>
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                                        </div>
                                                                </div><input class="form-control " value="<?php echo isset($arrOrderdetail['jurneydate3']) ? date('Y-m-d',strtotime($arrOrderdetail['jurneydate3'])) :''?>" placeholder="DD/MM/YYYY" type="date" style="width:100px" name="journey_date2" id="journey_date2">
                                                        </div>
                                                     </div>
                                                    </td>
                                                   <td width="5%">Tatkal</td>
                                                    <td>
                                                        <label class="custom-control custom-checkbox">
                                                            <?php 
                                                        $arrData = array('name'=>'tatkal','id'=>"tatkal",'value'=>"1",'class'=>'custom-control-input');
                                                        echo form_checkbox($arrData, isset($arrOrderdetail['tatkal']) ? $arrOrderdetail['tatkal'] :''); ?>
                                                            
                                                                <span class="custom-control-label"></span>
                                                        </label>
                                                    </td>
                                            </tr>
                                            <tr>
                                                    <td width="5%">Class</td> 
                                                    <td>
                                                    <div class="col-sm-4 col-md-4 float-left">
                                                        
                                                        <?php 
                                                        $arrExtra = array('id'=>"class_id",'class'=>'form-control select2 custom-select','data-placeholder'=>"Choose one");
                                                        echo form_dropdown('class_id',$arrClasscode, isset($arrOrderdetail['trainclassid']) ? $arrOrderdetail['trainclassid']:'',$arrExtra); ?>
                                                        
                                                        
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                            <?php 
                                                        $arrExtra = array('id'=>"class_id1",'class'=>'form-control select2 custom-select','data-placeholder'=>"Choose one");
                                                        echo form_dropdown('class_id1',$arrClasscode, isset($arrOrderdetail['trainclassid2']) ? $arrOrderdetail['trainclassid2'] :'',$arrExtra); ?>
                                                            
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                            <?php 
                                                        $arrExtra = array('id'=>"class_id2",'class'=>'form-control select2 custom-select','data-placeholder'=>"Choose one");
                                                        echo form_dropdown('class_id2',$arrClasscode, isset($arrOrderdetail['trainclassid3'])? $arrOrderdetail['trainclassid3']:'',$arrExtra); ?>
                                                     </div>
                                                    </td>
                                                   <td width="5%">Ticket Type</td>
                                                    <td>
                                                        <?php 
                                                        $arrExtra = array('id'=>"ticketorder_type",'class'=>'form-control select2 custom-select','data-placeholder'=>"Choose one");
                                                        echo form_dropdown('ticketorder_type',$arrTickettype, isset($arrOrderdetail['tickettypeid'])?$arrOrderdetail['tickettypeid']:'',$arrExtra); ?>
                                                        
                                                    </td>
                                            </tr>
                                            
                                            <tr>
                                                   <td width="5%">From Station</td> 
                                                    <td>
                                                    <div class="col-sm-4 col-md-4 float-left">
                                                        <?php 
                                                        $arrData = array('name'=>'ticketorder_fromstation','id'=>"ticketorder_fromstation",'placeholder'=>"From Station",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData, isset($arrOrderdetail['fromstation'])?$arrOrderdetail['fromstation']:''); ?>
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                            <?php 
                                                        $arrData = array('name'=>'ticketorder_tostation','id'=>"ticketorder_tostation",'placeholder'=>"To Station",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData, isset($arrOrderdetail['tostation'])?$arrOrderdetail['tostation']:''); ?>
                                                     </div>
                                                        
                                                    </td>
                                                    <td width="5%">Boarding</td>
                                                    <td><div class=" float-left">
                                                            <?php 
                                                        $arrData = array('name'=>'ticketorder_bording','id'=>"ticketorder_bording",'placeholder'=>"Bording",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData, isset($arrOrderdetail['bording'])?$arrOrderdetail['bording']:''); ?>
                                                     </div></td>
                                            </tr>
                                    </tbody>
                            </table>
                        
                        <label class="form-label">  &nbsp;Passenger Details</label>
                          <table class="table card-table table-vcenter text-nowrap table-warning">
                                        <thead class="bg-warning text-white">
                                                <tr>
                                                        <th>Sr</th>
                                                        <th>Name</th>
                                                        <th>Sex</th>
                                                        <th>Age</th>
                                                        <th>Id Name</th>
                                                        <th >Id Val</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                            <?php for($i=1;$i<=6;$i++){ $j=$i-1; ?>
                                                <tr>
                                                        <th scope="row"><?php echo $i; ?></th>
                                                        <td>
                                                            <?php 
                                                        $arrData = array('name'=>'name'.$i,'id'=>"name".$i,'placeholder'=>"Passenger Name",'class'=>'form-control');
                                                        $i==1 ? $arrData['required']='':'';
                                                        echo form_input($arrData,isset($arrOrderlisting[$j]['psgname'])?$arrOrderlisting[$j]['psgname'] :''); ?>
                                                            
                                                        </td>
                                                        <td width="10%">
                                                            <?php 
                                                            $arrExtra = array('id'=>"sex".$i,'class'=>'form-control select2 custom-select','data-placeholder'=>"Sex");
                                                            $i==1 ? $arrExtra['required']='':'';
                                                            echo form_dropdown('sex'.$i,$arrSex,isset($arrOrderlisting[$j]['sex'])?$arrOrderlisting[$j]['sex'] :'',$arrExtra); ?>
                                                            
                                                        </td>
                                                        <td width="10%">
                                                            <?php 
                                                        $arrData = array('name'=>'age'.$i,'id'=>"age".$i,'placeholder'=>"Age",'type'=>"number",'class'=>'form-control');
                                                        $i==1 ? $arrData['required']='':'';
                                                        echo form_input($arrData,isset($arrOrderlisting[$j]['age'])?$arrOrderlisting[$j]['age'] :''); ?>
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'pid'.$i,'id'=>"pid".$i,'placeholder'=>"Id Name",'class'=>'form-control');
                                                        $i==1 ? $arrData['required']='':'';
                                                        echo form_input($arrData,isset($arrOrderlisting[$j]['idname'])?$arrOrderlisting[$j]['idname'] :''); ?>
                                                           
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'piv'.$i,'id'=>"piv".$i,'placeholder'=>"Id Value",'class'=>'form-control');
                                                        $i==1 ? $arrData['required']='':'';
                                                        echo form_input($arrData,isset($arrOrderlisting[$j]['idvalue'])?$arrOrderlisting[$j]['idvalue'] :''); ?>
                                                        </td>
                                                </tr>
                                            <?php } ?>
                                                
                                                
                                                
                                        </tbody>
                                </table>
                            
                            
                            <table class="table card-table table-vcenter text-nowrap table-primary">
                                       
                                        <tbody>
                                                <tr>
                                                    <td width="10%">Advance</td>  
                                                        <td >
                                                            <?php 
                                                        $arrData = array('name'=>'advance','id'=>"advance",'placeholder'=>"Advance amount",'type'=>"number",'class'=>'form-control');
                                                        echo form_input($arrData, isset($arrOrderdetail['advamount'])?$arrOrderdetail['advamount']:''); ?>
                                                           
                                                        </td>
                                                        <td width="10%">Type</td> 
                                                        <td>
                                                            <?php 
                                                        $arrExtra = array('id'=>"ticket_type",'class'=>'form-control select2 custom-select','data-placeholder'=>"Choose one");
                                                        echo form_dropdown('ticket_type',$arrType, isset($arrOrderdetail['type'])?$arrOrderdetail['type']:'',$arrExtra); ?>
                                                        </td>
                                                        
                                                </tr>
                                                
                                        </tbody>
                                </table>

                    </div>
                    <!-- table-responsive -->
                    
                    <div style=" padding-left: 100px; padding-bottom: 10px"> 
                         <?php 
                            $arrData = array('name'=>'Submit','class'=>'btn btn-success  btn-lg pull-left','style'=>"margin-left: 5px;");
                            echo form_submit($arrData,'Update'); ?>
                        
                        <?php 
                            $arrData = array('name'=>'btnnewtransaction','id'=>'btnnewtransaction','onclick'=>'javascript:newtransactionf();','class'=>'btn btn-secondary  btn-lg pull-left','style'=>"margin-left: 5px;");
                            echo form_button($arrData,'New Transaction'); ?>
                        <a href="<?php echo site_url('printorder?orderno='.$arrOrderdetail['orderno'].'&transactionno='.$arrOrderdetail['transactioncount']); ?>" target="_blank">
                        <?php 
                            $arrData = array('name'=>'btnprint','id'=>'btnprint','class'=>'btn btn-indigo  btn-lg pull-left','style'=>"margin-left: 5px;");
                            echo form_button($arrData,'Print'); ?>
                        </a>
                           </div>
                 </div>
                    
                    
                    
                    
                            </form>
                   
                </div>
            </div>
        </div>
    </div>

</div>
<script src="<?php echo base_url('js/jquery1.9.min.js'); ?>"></script>
<script type="text/javascript">
    
    function newtransactionf()
    {
         
         $('#newtransaction').val('1');
       //  $('#transaction').val('0').change();
         $('#transaction').val('0').change();
         $('#advance').val('');
         $('#btnnewtransaction').hide();
         $('#btnprint').hide();
    }
    function tbnsearch()
     {
         var orderid = document.getElementById('order_number').value;    
        var url= "<?php echo site_url('editorder?orderno=');?>"+orderid;   
        //alert(url);   
        window.location.href=url;
     }
     
     
   $(document).ready(function(){
     
      $('#transaction').change(function() {  
        var trno = $('#transaction').val();   
        
        var orderid = document.getElementById('order_number').value;
        var url= "<?php echo site_url('editorder?orderno=');?>"+orderid+"&transactionno="+trno;
        window.location.href=url;
    });
     
     $('#ticketorder_trainid').blur(function() { 
        var tranino = $('#ticketorder_trainid').val();
        var data = 'tranino='+ tranino ; 
        $.ajax({           
            url:"<?php echo site_url('gettraindetail');?>",
           data: "tranino="+tranino,
            type: "POST",  
            success: function(data){  
                //alert(data);
                objTrain = JSON.parse(data); 
                if(document.getElementById('ticketorder_trainid').value=="")
                {
                    return false;  
                }
              
                if(objTrain.name=="")
                {
                    alert("Invalid Train no");
                    $('#ticketorder_trainid').val('');
                    //  $('#ticketorder_trainid').focus();
                }
                
                    
                $('#ticketorder_trainname').val(objTrain.name);
                $('#ticketorder_fromstation').val(objTrain.fromstation);
                $('#ticketorder_tostation').val(objTrain.tostation);
                $('#ticketorder_bording').val(objTrain.fromstation);
                
            }
        });  
    });     
     
     
    });
    
</script>