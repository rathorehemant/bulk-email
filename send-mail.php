<?php 
include('includes/navbar.php');
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Send Mail </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Send Mail</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<section class="content">
<div class="container-fluid">
<!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Send mail </h3>

            
          </div>
          <!-- /.card-header -->
          <div class="card-body">
              <form id = "send-email" enctype="multipart/form-data" method = "post">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Choose file</label>
                  <input class="form-control" type ="file" name = "csv" id = "file">
                  
                    
                </div>
                
                <div class="card">
               <div class="card-body" style="
               display: none";>
                <h5 class="card-title"></h5>
                <p class="card-text"></p>
              </div>
                </div>
                
                <div class="form-group">
                  <label>Mail To <span class = "text-danger">*</span></label>
                  <input class="form-control" type ="text" name = "email_field" id = "email_field" ">
                </div>
                <div class="form-group">
                  <label>Subject <span class = "text-danger">*</span></label>
                  <input class="form-control" type ="text" name = "email_subject" id = "email_subject">
                </div>
                
                
                <div class="form-group">
                  <label>Message</label>
                  <teaxtarea class="form-control" id = "editor" name="editor1"></teaxtarea>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-success send">Send mail</button>
                </div>
                
                <div class ="result">
                  
                </div>
                
              </div>
              
            </div>
            
            </form>
          </div>
          <!-- /.card-body -->
          
        </div>
</div>

</section>
</div>
<?php 
include('includes/footer.php');
?>
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>




<script>
CKEDITOR.replace( 'editor1' );

</script>
