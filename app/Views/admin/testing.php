<?php $session = session(); ?>
<style>
    @media only screen and (max-width: 600px) {
        .for-mobile-laptop {
            margin: 0;
        }
    }
    label {
        float: left
    }
    span {
        display: block;
        overflow: hidden;
        padding: 0 4px 0 6px
    }
    input {
        width: 100%
    }
.mandatory {
display:inline;
color:red;
}.fa {
color:red !important;
}
</style> 

<style>
select {
  width: 400px;
  padding: 8px 16px;
}
select option {
  font-size: 14px;
  padding: 8px 8px 8px 28px;
  position: relative;

}
select option:before {
  content: "";
  position: absolute;
  height: 18px;
  width: 18px;
  top: 0;
  bottom: 0;
  margin: auto;
  left: 0px;
  border: 1px solid #ccc;
  border-radius: 2px;
  z-index: 1;
}
select option:checked:after {
  content: attr(data[count]);
  background: #fff;
  color: black;
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  padding: 8px 8px 8px 28px;
  border: none;
}
select option:checked:before {
  border-color: blue;
  content: "\2713";
 height:20px;
  background-size: 10px;
  background-repeat: no-repeat;
  background-position: center;
}
</style>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                    <?php echo view('admin/_topmessage'); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="card-title">Edit Product</h4>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="card-title">Arebic</h4>
                            </div>
                        </div><br>

                        <form class="custom-validation"  method='post' action="CustomOfferController/EditCustomOffer" enctype='multipart/form-data'>
                           <input type="hidden" id="offer_id" name="offer_id" value="<?php echo $customOffers->st_id; ?>">
                    
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Custom Offer<span class="mandatory">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Custom Offer"  class="form-control" name="st_name" cols="6" value="<?php echo $customOffers->st_name?>" rows="4" required></input>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Arabic Custom Offer<span class="mandatory">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" value="<?php echo $customOffers->st_arb_name?>" placeholder="Arabic Custom Offer "  class="form-control" name="st_arb_name" cols="6" rows="4" required></input>
                                </div>
                            </div>

                             <div class="form-group row mb-0">
                                <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                                                Submit
                                    </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo site_url('CustomOfferDetails');?>">
                                    <button type="button" class="btn btn-primary waves-effect waves-light mr-1">Clear</button>
                                    </a>
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



