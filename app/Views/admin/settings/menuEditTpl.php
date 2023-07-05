<div id="page-wrapper">
    <?php $this->load->view('admin/_topmessage'); ?>


    <div class="row">
        <div class="col-md-12 col-sm-12 useraddform">
            <div class="panel panel-default" style="margin-top:-30px">
                <div class="panel-heading">
                    <img src="<?php echo base_url("assets/admin/images/group.png"); ?>" height="35" width="35">
                    <b style="font-size:16px;">Update Menu</b>
                    <a href="<?php echo site_url('adminMenuList/index'); ?>" class="btn btn-warning pull-right">Back</a>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">

                    <div class="col-md-10 col-sm-10">


                        <div id="divSuccess" style="display:none;"></div>

                        <form action="<?php echo site_url("adminMenuList/updateMenuName?id=" . $menuDetailArray->id); ?>" method="post" name="addGroupForm" id="addGroupForm"  enctype="multipart/form-data">

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td width="30%" ><span class="Ment"> * </span>  <b>Display Name :</b></td>
                                        <td width="70%" >
                                            <input type="text" name="txtName" id="txtName" class="form-control" value="<?php echo $menuDetailArray->display_menu_name; ?>" required>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td ><b>Status:</b></td>
                                        <td >
                                            <div class=" col-md-4">	<select id="txtStatus" name="txtStatus" class="form-control">
                                                    <option <?php if ($menuDetailArray->status == 0) { ?> selected="selected" <?php } ?> value="0">Inactive</option>
                                                    <option <?php if ($menuDetailArray->status == 1) { ?> selected="selected"<?php } ?> value="1">Active</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="2" align="center" >
                                            <input type="submit" class="btn btn-success" value="Update" name="filter">
                                            <a href="<?php echo site_url('adminMenuList/index'); ?>" class="btn btn-primary">Back </a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </form>



                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>





<script>

    newj(document).ready(function() {
        newj("#addGroupForm").validate({
            rules: {
                txtName: {
                    required: true
                }
            },
            messages: {
                txtName: {
                    required: " Please enter Display Name"
                }
            }
        });


	
	

	
    });

</script>
