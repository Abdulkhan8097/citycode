<?php $session = session(); ?>
<style>
/*   @media only screen and (max-width: 600px) {
   .for-mobile-laptop {
   margin: 0;
   }
   }*/
   .mandatory {
   display:inline;
   color:red;
   }
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
                  <div class="row">
                     <div class="col-sm-6">
                        <h4 class="card-title"><?php echo $pagetitle; ?></h4>
                     </div>
                     <div class="col-sm-6">
                     
                     </div>
                  </div>
                  <form class="custom-validation"  method='post' action="VersionControl/save">
                     <div class="for-mobile-laptop">
                         
                    
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="inputPassword" class="col-sm-4 col-form-label">Version no<span class="mandatory">*</span></label>
                                 <div class="col-sm-6">
                                    <input type="text" name="version_no"  onkeypress="numericFilter(this)" placeholder="Enter version no"  class="form-control"  value="" required>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group row mb-0">
                           <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                           <div class="col-sm-6">
                              <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="owner-submit-btn">
                              Submit
                              </button>
                              <a class="btn btn-secondary waves-effect waves-light" onclick="history.back()">
                              <i class="ion ion ion-md-arrow-back"></i> Back
                              </a>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <!-- end col -->
      </div>
      <!-- end row -->    
   </div>
   <!-- container-fluid -->
</div>
<!-- End Page-content -->

    
<script>
   function numericFilter(txb) {
       txb.value = txb.value.replace(/[^\0-9]/ig, "");
   }

</script>

