<div class="col-lg-12 ml-auto text-center">
          <div class="ex-page-content">
              <h3 class="text-secondary display-1 mt-4"><i class="fa fa-search-plus"></i></h3>
              <h4 class="mb-4">
              <?php if(isset($noResult["message"]))  echo $noResult["message"]; else echo  "No Result Found"; ?>
              </h4>
              <p class="mb-5 ">
              <?php if(isset($noResult["description"]))  echo $noResult["description"]; ?>
            </p>
             
          </div>

      </div>   