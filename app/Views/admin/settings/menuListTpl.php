<div class="row">
    <div class="col-sm-12" ><h3><img src="<?php echo base_url("assets/admin/images/group.png");?>" height="30" width="30">Menu Management</h3></div>
  <div class="col-sm-12">
      <?php $this->load->view('admin/_topmessage'); ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <div>
        <form action="<?php echo site_url('adminMenuList/index');?>" method="post" class="form-inline" name="search_list_form" id="search_list_form">
          <div class="form-group">
              <input type="text" maxlength="15" class="form-control input-sm" value="<?php echo $searchArray["menuTitle"];?>" id="group_title" name="menu_title">
          </div>
            
            <div class="form-group">
                <select class="form-control" id="filters_status" name="filters_status">
                    <option value="-1">All</option>
                    <option value="1" <?php if($searchArray["status"] == 1){echo "selected='selected'";}?>>Active</option>
                    <option value="0" <?php if($searchArray["status"] == 0){echo "selected='selected'";}?>>Inactive</option>
                  </select>
            </div>
          <button type="submit" class="btn btn-success btn-sm">Search</button>
          <a href="<?php echo site_url('adminMenuList/index');?>" class="btn btn-primary btn-sm" style="margin-right:10px">Refresh</a>
          
        </form>

      </div>
    </div>
    <div class="panel-body">
      <div class="col-md-12 ">
        <div class="table-resposive">
        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th width="1%">SNo.</th>
              <th>Menu Name</th>
              <th>Display Name</th>
              <th>Status</th>
              <th width="15%">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if($pagination['getNbResults']){ $i=$startLimit;?>
              <?php foreach($menuData as $kData){ ?>
                <tr>
                  <td><?php echo ++$i;?></td>
                  <td><?php echo $kData->menu_name;?></td>
                  <td><?php echo $kData->display_menu_name;?></td>
                  <td><?php if($kData->status == 0) echo "Inactive"; else echo "Active";?></td>
                  
                  <td>                      
                    <a class="btn btn-info btn-sm" href="<?php echo site_url("adminMenuList/editMenu?id=".$kData->id); ?>" title="Edit"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
              <?php } } else{ ?>
            <tr>
              <td colspan="9"><div class="alert alert-info text-center">No Record Found!<a class="close" data-dismiss="alert">x</a></td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>
  <div class="col-md-12">
     <?php if($pagination['haveToPaginate']){ ?>
        <?php $this->load->view('admin/_paging',array('paginate'=>$pagination,'siteurl'=>'adminMenuList/index','varExtra'=>array('search'=>$search))); ?>
        <?php } ?>
        </div>
</div>
</div>    
