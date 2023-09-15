
$('.nav-item a').click(function(){
  $('.nav-item a.active').removeClass("active");
  $(this).addClass("active");
});

// for get available placholder from csv file
            $("#file").change(function() {
            var file = $(this)[0].files[0];
              var formdata = new FormData();
              formdata.append('csv', file);
            
            $.ajax({
                url :'placeholders.php',
                type :'post',
                data:formdata,
                dataType: 'text',
                processData: false,
                contentType: false,
                success:function(result){
                    $(".card-body").removeAttr("style");
                    $(".card-title").text("Available placeholders");
                    $('.card-text').html(result);
                },
                error: function() {
                     $(".card-body").removeAttr("style");
                    $(".card-title").text("");
                    $('.card-text').html('something went wrong');
                 
            }  
                
            });
    });


// //for submit the form 
            $('#send-email').submit(function(e) {
                e.preventDefault();
                $('.result').html('');
                var email_filed = $("#email_field").val();
                var email_subject = $("#email_subject").val();
                if(email_filed == ''){
                   swal("Error", "Please enter your mail to :", "error");
                    
                }else if(email_subject == ''){
                     swal("Error", "Please enter email subject :", "error");
                }else{
                  var formdata = new FormData(this);
                  $(".send").text("Please wait....");
                  $(".send").attr('disabled','disabled');
           
         var TextGrab = CKEDITOR.instances.editor.getData();
     
      formdata.append('editor1', TextGrab);
            $.ajax({
                
                url : 'mail-process.php',
                type : 'POST',
                data:formdata,
                dataType: 'text',
                processData: false,
                contentType: false,
                
                success:function(result){
                     
                    $('.result').html(result);
                    $(".send").text("Send mail");
                  $(".send").removeAttr('disabled')
                },
                error: function() {
                    $('.result').html('something went wrong');
                 
            }  
                
            }); 
                }
                
});
