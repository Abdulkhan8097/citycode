<?php helper('form'); ?>
<div class="app-content bg-img my-3 my-md-5">
    <div class="side-app">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                 <?php echo view('admin/_topmessage'); ?>
                <div>
                <form class="card" id='add_member_form' method='post' action="<?php echo site_url('addOrder'); ?>" enctype='multipart/form-data'>    
                    <div>
                   <?php echo \Config\Services::validation()->listErrors(); ?>
                    <?php echo csrf_field() ?>
                    <div class="table-responsive">
                        <label class="form-label">  &nbsp;Create New Order</label>
                            <table class="table card-table table-vcenter text-nowrap table-primary">
                                    
                                    <tbody>
                                            <tr>
                                                <td width="5%">Order No</td>
                                                   
                                                    <td>
                                                        <div class="col-sm-3 col-md-3 float-left"> 
                                                        <?php 
                                                        $arrData = array('name'=>'order_number','id'=>"order_number",'type'=>'number','class'=>'form-control','placeholder'=>"Order No");
                                                        echo form_input($arrData,''); ?>
                                                        </div>
                                                        <div class="col-sm-3 col-md-3 float-left">
                                                        
                                                            <button type="button" class="btn btn-secondary mb-1" id="btnSearch" onclick="javascript:tbnsearch();">Search</button>
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
                                                        echo form_input($arrData,''); ?>
                                                        </div>
                                                    </td>
                                                   
                                                    <td width="5%">Order Date</td>
                                                    <td>
                                                    
                                                            <div class="input-group col-sm-10">
                                                                <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                                        </div>
                                                                </div><input class="form-control " value="<?php echo date('Y-m-d')?>"  placeholder="DD-MM-YYYY" type="date" style="width:100px" name="booking_date" id="booking_date" required>
                                                        </div>
                                                    </td>
                                            </tr>
                                            <tr>
                                                 <td width="5%">Customer Name</td>   
                                                    <td>
                                                    <div class="col-sm-6 col-md-6 float-left">
                                                        <?php 
                                                        $arrData = array('name'=>'customer_name','id'=>"customer_name",'required'=>'','placeholder'=>"Customer Name",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        </div>
                                                    </td>
                                                   
                                                    <td width="5%">Phone Number</td>
                                                    <td>
                                                    <div class="float-left">
                                                        <?php 
                                                        $arrData = array('name'=>'phone','id'=>"phone",'placeholder'=>"Phone number",'required'=>'','type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        
                                                     </div>
                                                    </td>
                                            </tr>
                                            <tr>
                                                  <td width="5%">Train Number</td>  
                                                    <td>
                                                    <div class="col-sm-4 col-md-4 float-left">
                                                        
                                                        <?php 
                                                        $arrData = array('name'=>'ticketorder_trainid','id'=>"ticketorder_trainid",'placeholder'=>"Train Number",'required'=>'','type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                       <?php 
                                                        $arrData = array('name'=>'ticketorder_trainid1','id'=>"ticketorder_trainid1",'placeholder'=>"Train Number",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                         </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                        <?php 
                                                        $arrData = array('name'=>'ticketorder_trainid2','id'=>"ticketorder_trainid2",'placeholder'=>"Train Number",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                     </div>
                                                    </td>
                                                    
                                                    <td width="5%">Train Name</td>
                                                   
                                                    <td><div class=" float-left">
                                                        
                                                            <?php 
                                                        $arrData = array('name'=>'ticketorder_trainname','id'=>"ticketorder_trainname",'placeholder'=>"Train Name",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                            
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
                                                                </div><input class="form-control" placeholder="DD/MM/YYYY" type="date"  style="width:100px" name="journey_date" id="journey_date" required>
                                                        </div>
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                       <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                                        </div>
                                                                </div><input class="form-control " placeholder="DD/MM/YYYY" type="date" style="width:100px" name="journey_date1" id="journey_date1">
                                                        </div>
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                                        </div>
                                                                </div><input class="form-control " placeholder="DD/MM/YYYY" type="date" style="width:100px" name="journey_date2" id="journey_date2">
                                                        </div>
                                                     </div>
                                                    </td>
                                                   <td width="5%">Tatkal</td>
                                                    <td>
                                                        <label class="custom-control custom-checkbox">
                                                            <?php 
                                                        $arrData = array('name'=>'tatkal','id'=>"tatkal",'value'=>"1",'class'=>'custom-control-input');
                                                        echo form_checkbox($arrData,''); ?>
                                                            
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
                                                        echo form_dropdown('class_id',$arrClasscode,'',$arrExtra); ?>
                                                        
                                                        
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                            <?php 
                                                        $arrExtra = array('id'=>"class_id1",'class'=>'form-control select2 custom-select','data-placeholder'=>"Choose one");
                                                        echo form_dropdown('class_id1',$arrClasscode,'',$arrExtra); ?>
                                                            
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                            <?php 
                                                        $arrExtra = array('id'=>"class_id2",'class'=>'form-control select2 custom-select','data-placeholder'=>"Choose one");
                                                        echo form_dropdown('class_id2',$arrClasscode,'',$arrExtra); ?>
                                                     </div>
                                                    </td>
                                                   <td width="5%">Ticket Type</td>
                                                    <td>
                                                        <?php 
                                                        $arrExtra = array('id'=>"ticketorder_type",'class'=>'form-control select2 custom-select','data-placeholder'=>"Choose one");
                                                        echo form_dropdown('ticketorder_type',$arrTickettype,'',$arrExtra); ?>
                                                        
                                                    </td>
                                            </tr>
                                            
                                            <tr>
                                                   <td width="5%">From Station</td> 
                                                    <td>
                                                    <div class="col-sm-4 col-md-4 float-left">
                                                        <?php 
                                                        $arrData = array('name'=>'ticketorder_fromstation','id'=>"ticketorder_fromstation",'placeholder'=>"From Station",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                     </div>
                                                        <div class="col-sm-4 col-md-4 float-left">
                                                            <?php 
                                                        $arrData = array('name'=>'ticketorder_tostation','id'=>"ticketorder_tostation",'placeholder'=>"To Station",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                     </div>
                                                        
                                                    </td>
                                                    <td width="5%">Boarding</td>
                                                    <td><div class=" float-left">
                                                            <?php 
                                                        $arrData = array('name'=>'ticketorder_bording','id'=>"ticketorder_bording",'placeholder'=>"Bording",'type'=>'text','class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
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
                                                <tr>
                                                        <th scope="row">1</th>
                                                        <td>
                                                            <?php 
                                                        $arrData = array('name'=>'name1','id'=>"name1",'placeholder'=>"Passenger Name",'required'=>'','class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                            
                                                        </td>
                                                        <td width="10%">
                                                            <?php 
                                                            $arrExtra = array('id'=>"sex1",'class'=>'form-control select2 custom-select','required'=>'','data-placeholder'=>"Sex");
                                                            echo form_dropdown('sex1',$arrSex,'',$arrExtra); ?>
                                                            
                                                        </td>
                                                        <td width="10%">
                                                            <?php 
                                                        $arrData = array('name'=>'age1','id'=>"age1",'placeholder'=>"Age",'type'=>"number",'required'=>'','class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'pid1','id'=>"pid1",'placeholder'=>"Id Name",'required'=>'','class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                           
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'piv1','id'=>"piv1",'placeholder'=>"Id Value",'required'=>'','class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        </td>
                                                </tr>
                                                
                                                <tr>
                                                        <th scope="row">2</th>
                                                        <td>
                                                            <?php 
                                                        $arrData = array('name'=>'name2','id'=>"name2",'placeholder'=>"Passenger Name",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                            
                                                        </td>
                                                        <td width="10%">
                                                            <?php 
                                                            $arrExtra = array('id'=>"sex2",'class'=>'form-control select2 custom-select','required'=>'','data-placeholder'=>"Sex");
                                                            echo form_dropdown('sex2',$arrSex,'',$arrExtra); ?>
                                                           
                                                        </td>
                                                        <td width="10%">
                                                            <?php 
                                                        $arrData = array('name'=>'age2','id'=>"age2",'placeholder'=>"Age",'type'=>"number",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'pid2','id'=>"pid2",'placeholder'=>"Id Name",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                           
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'piv2','id'=>"piv2",'placeholder'=>"Id Value",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <th scope="row">3</th>
                                                        <td>
                                                            <?php 
                                                        $arrData = array('name'=>'name3','id'=>"name3",'placeholder'=>"Passenger Name",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                            
                                                        </td>
                                                        <td width="10%">
                                                         <?php 
                                                            $arrExtra = array('id'=>"sex3",'class'=>'form-control select2 custom-select','required'=>'','data-placeholder'=>"Sex");
                                                            echo form_dropdown('sex3',$arrSex,'',$arrExtra); ?>
                                                        </td>
                                                        <td width="10%">
                                                            <?php 
                                                        $arrData = array('name'=>'age3','id'=>"age3",'placeholder'=>"Age",'type'=>"number",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'pid3','id'=>"pid3",'placeholder'=>"Id Name",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                           
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'piv3','id'=>"piv3",'placeholder'=>"Id Value",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <th scope="row">4</th>
                                                        <td>
                                                            <?php 
                                                        $arrData = array('name'=>'name4','id'=>"name4",'placeholder'=>"Passenger Name",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                            
                                                        </td>
                                                        <td width="10%">
                                                         <?php 
                                                            $arrExtra = array('id'=>"sex4",'class'=>'form-control select2 custom-select','required'=>'','data-placeholder'=>"Sex");
                                                            echo form_dropdown('sex4',$arrSex,'',$arrExtra); ?>
                                                        </td>
                                                        <td width="10%">
                                                            <?php 
                                                        $arrData = array('name'=>'age4','id'=>"age4",'placeholder'=>"Age",'type'=>"number",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'pid4','id'=>"pid4",'placeholder'=>"Id Name",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                           
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'piv4','id'=>"piv4",'placeholder'=>"Id Value",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <th scope="row">5</th>
                                                        <td>
                                                            <?php 
                                                        $arrData = array('name'=>'name5','id'=>"name5",'placeholder'=>"Passenger Name",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                            
                                                        </td>
                                                        <td width="10%">
                                                         <?php 
                                                            $arrExtra = array('id'=>"sex5",'class'=>'form-control select2 custom-select','required'=>'','data-placeholder'=>"Sex");
                                                            echo form_dropdown('sex5',$arrSex,'',$arrExtra); ?>
                                                        </td>
                                                        <td width="10%">
                                                            <?php 
                                                        $arrData = array('name'=>'age5','id'=>"age5",'placeholder'=>"Age",'type'=>"number",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'pid5','id'=>"pid5",'placeholder'=>"Id Name",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                           
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'piv5','id'=>"piv5",'placeholder'=>"Id Value",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <th scope="row">6</th>
                                                        <td>
                                                            <?php 
                                                        $arrData = array('name'=>'name6','id'=>"name6",'placeholder'=>"Passenger Name",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                            
                                                        </td>
                                                        <td width="10%">
                                                         <?php 
                                                            $arrExtra = array('id'=>"sex6",'class'=>'form-control select2 custom-select','required'=>'','data-placeholder'=>"Sex");
                                                            echo form_dropdown('sex6',$arrSex,'',$arrExtra); ?>
                                                        </td>
                                                        <td width="10%">
                                                            <?php 
                                                        $arrData = array('name'=>'age6','id'=>"age6",'placeholder'=>"Age",'type'=>"number",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'pid6','id'=>"pid6",'placeholder'=>"Id Name",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                           
                                                        </td>
                                                        <td width="15%">
                                                            <?php 
                                                        $arrData = array('name'=>'piv6','id'=>"piv6",'placeholder'=>"Id Value",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                        </td>
                                                </tr>
                                                
                                        </tbody>
                                </table>
                            
                            
                            <table class="table card-table table-vcenter text-nowrap table-primary">
                                       
                                        <tbody>
                                                <tr>
                                                    <td width="10%">Advance</td>  
                                                        <td >
                                                            <?php 
                                                        $arrData = array('name'=>'advance','id'=>"advance",'placeholder'=>"Advance amount",'type'=>"number",'class'=>'form-control');
                                                        echo form_input($arrData,''); ?>
                                                           
                                                        </td>
                                                        <td width="10%">Type</td> 
                                                        <td>
                                                            <?php 
                                                        $arrExtra = array('id'=>"ticket_type",'class'=>'form-control select2 custom-select','data-placeholder'=>"Choose one");
                                                        echo form_dropdown('ticket_type',$arrType,'',$arrExtra); ?>
                                                        </td>
                                                        
                                                </tr>
                                                
                                        </tbody>
                                </table>

                    </div>
                    <!-- table-responsive -->
                    
                    <div style=" padding-left: 100px; padding-bottom: 10px"> 
                         <?php 
                            $arrData = array('name'=>'Submit','class'=>'btn btn-success  btn-lg pull-left');
                            echo form_submit($arrData,'Generate'); ?>
                            
                        <a href="<?php echo site_url('dashboard');?>"><button type="button" class="btn btn-danger btn-lg  pull-left" style="margin-left: 5px;">Cancel</button></a>
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
    
     
      function tbnsearch()
     {
         var orderid = document.getElementById('order_number').value; 
         if(orderid=='')
         {
             alert('Please enter order number');
             return;
         }
        var url= "<?php echo site_url('editorder?orderno=');?>"+orderid;   
        //alert(url);   
        window.location.href=url;
     }
     
   $(document).ready(function(){
     
     
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