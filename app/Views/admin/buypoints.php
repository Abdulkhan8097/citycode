<style type="text/css">
    .set{padding: calc(0px) calc(0px / 6) 59px calc(251px / 1);
    }
</style>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                    <?php echo view('admin/_topmessage'); ?>
                                 <h2 >Buy Points</h2><p>Enter 6 Points List with Amount</p>
					

                                 <form class="custom-validation"  method='post' action="<?php echo site_url("OpeningPoint/buyPointSave"); ?>" enctype='multipart/form-data'>
                            <div class="for-mobile-laptop">

                           
                                           <div class="form-group row">
                                            <label  class="col-sm-1 col-form-label">Points :</label>
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" placeholder="Enter Points" name="points" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['points'] : ''; ?>"/>
                                            </div> 
                                        </div>
                                    
                                        <div class="form-group row">
                                            <label  class="col-sm-1 col-form-label">Amount :</label>
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" name="amt" placeholder="Enter Amount" value="<?php echo (isset($edit) && !empty($edit)) ? $edit['amount'] : ''; ?>"/>
                                            </div> 
                                        </div>
                                        </div>

                            <div class="form-group row mb-0">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-6">
                                     <input type="hidden" name="id"  value="<?php echo (isset($edit) && !empty($edit)) ? $edit['id'] : ''; ?>">  
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                        Submit
                                    </button> 
                                </div>
                            </div>
                       </div>
                    </form>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->    
</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->


<div class="set">
    <div class="container-fluid">
  <div class="row">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-body">
                       <?php if($pagination["getNbResults"] >0 ){ ?>
                        <div class="table-responsive">
                            <table  data-toggle="table" data-striped="true" class="table table-hover table-centered table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center" data-field="Sl. No." data-sortable="true">Sl. No.</th>
                                        <th class="text-center" data-field="City Code" data-sortable="true">Points</th>
                                        <th class="text-center" data-field="VIP Code" data-sortable="true">Amout</th>
                                        <th class="text-center" data-field="Full Name" data-sortable="true">Created</th>
                                        <th class="text-center" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php 
                                        $i=0;
                                        foreach ($customers as $kdata) {
                                            $i++;
                                            ?>
                                            <th class="text-center"><?php echo $i; ?></th>
                                            <td class="text-center"><?php echo $kdata->points; ?></td>
                                            <td class="text-center"><?php echo $kdata->amount; ?></td>
                                            <td class="text-center"><?php echo $kdata->created ; ?></td>
                                          
                                            <td class="text-center">
                                            
                                                <a class="btn btn-dark waves-effect waves-light" href="<?php echo site_url('buypoints?id=' . $kdata->id); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a> 
                                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('OpeningPoint/delete?id=' . $kdata->id); ?>" onClick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i>
                                                </a> 
                                                
                     
                                            </td>                                          
                                        </tr>
                       
                                   <?php } ?>  

                                </tbody>
                            </table>
<?php if ($pagination['haveToPaginate']) { ?>
                                <br>
    <?php echo view('admin/_paging', array('paginate' => $pagination, 'siteurl' => 'Customers', 'varExtra' => $searchArray)); ?>

<?php } ?>
                        </div>
                        
                          <?php }else{ ?>
                            <?php echo view('admin/_noresult'); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->