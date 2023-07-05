$(document).ready(function() {

  // Owner Email Check
  $('#useremail').on('blur',function(){
    Checkuseremailexist();
  });

  function Checkuseremailexist(){
    var email = $('#useremail').val();
    $.ajax({
        type: "POST",
        url: 'Checkuseremailexist',
        data: {email: email},
        dataType:"json",//return type expected as json
        success: function(response){
          if(response > 0){
            $('#email-exist-error-msg').html('Email Already Exist. Please try another Email ID.');
            $("#owner-submit-btn").attr("disabled", true);
          } else {
            $('#email-exist-error-msg').empty();
            $("#owner-submit-btn").attr("disabled", false);
          }               

        },
    });        
  }


  // Owner ccording to Subadmin
  $('#subadminlist').change(function(){
    Checkowneraccordingtosubadmin();
  });

  function Checkowneraccordingtosubadmin(){
    var subadmin = $('#subadminlist').val();
    $.ajax({
        type: "POST",
        url: 'Checkowneraccordingtosubadmin',
        data: {subadmin: subadmin},
        dataType:"json",//return type expected as json
        success: function(response){           
          
          $('#ownerslist').empty();

          $('#ownerslist').append('<option selected disabled value="">Select Owner</option>');

          $.each(response, function (index, data) {
            $('#ownerslist').append('<option value='+ data["id"] +'>' + data["fname"] + ' ' + data["lname"] + '</option>');
          });
        },
    });        
  }

  //remove icon
  $('.removeicon').click(function(){
      var med_id = $('#med_id').val();
      var med_icon = $('#image_icon').val();
      
      $.ajax({
        type:'post',
        data:{med_id:med_id, med_icon:med_icon},
        url :'AdminController/remove_medicine_icon',
        success:function(res)
        {
          alert('Image Successfully Removed.');
          location.reload();
        }
      });
  });

  //remove image
  $('.removeimages').click(function(){
      var med_id = $('#med_id').val();
      var image_id = $('#image_gallery_id').val();
      var image_name = $('#image_gallery_name').val();
      
      
      $.ajax({
        type:'post',
        data:{med_id:med_id, image_id:image_id, image_name:image_name},
        url :'AdminController/delete_medicine_image',
        success:function(res)
        {
          alert('Image Successfully Removed.');
          location.reload();
        }
      });
  });


});