<?php 
include('includes/navbar.php');

$user_id = $_SESSION['uid'];

// fetch my smtp details for current user from database if available
$fetch = "SELECT * FROM `smtp-config` WHERE `user_id` = $user_id ";
$query = mysqli_query($db,$fetch);
$smtp_host = '';
$smtp_username = '';
$smtp_password = '';
$enc_type = '';
$smtp_port = '';
$send_form = '';
$set_name = '';

$button_text = "";
$button_value="";
 $html = ""; 
 $action = "";
    
if($query){
    
    if(mysqli_num_rows($query) > 0 ){
        $button_text = 'update';
        $button_value = 'update';
        $html = '<div class="alert alert-warning" role="alert">
  Your SMTP Password (The saved password is not shown for security reasons. If you do not want to update the saved password, you can leave this field empty when updating other options).
</div>';
$action = 'update';
        while($row=mysqli_fetch_assoc($query)){
      $smtp_host = $row['smtp_host'];
      $smtp_username = $row['smtp_username'];
      $smtp_password = $row['smtp_password'];
      $enc_type = $row['encryption_type'];
      $smtp_port = str_replace(' ', '', $row['smtp_port']);
      $send_form = $row['send_form'];
      $set_name = $row['set_name'];
       
  }
    }else{
        $button_text = 'submit';
        $button_value = 'submit';
        $action = 'insert';
    }
   
}

//switch case according to action
if(isset($_POST['action'])){
    switch($_POST['action']){
        // insert record
        case 'insert':
            // for insert record in database
if(isset($_POST['submit'])){
     $host = trim($db -> real_escape_string($_POST['smtp_host']));
    $username = trim($db -> real_escape_string($_POST['smtp_username']));
    $password = trim($db -> real_escape_string($_POST['smtp_password']));
    $enc_type = trim($db -> real_escape_string($_POST['enc_type']));
    $smtp_port = trim($db -> real_escape_string($_POST['smtp_port']));
    $send_form = trim($db -> real_escape_string($_POST['send_form']));
    $set_name = trim($db -> real_escape_string($_POST['set_name']));
   
 
    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
    // validation error
    if($host == '' || $username == '' || $password == '' || $enc_type == '' || $send_form == '' || $set_name == ''){
        $_SESSION['errors'] = 'Please fill all required fields';
    }
    else if(!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'] = 'Please provide valid email address for smtp username';
    }
    else if(!filter_var($send_form, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'] = 'Please provide valid email address for send from email';
    }else{

    // insert record 
    $insert = "INSERT INTO `smtp-config`(`user_id`, `smtp_host`, `smtp_username`, `smtp_password`,`encryption_type`,`smtp_port`, `send_form`, `set_name`) VALUES ('$user_id','$host','$username','$password','$enc_type','$smtp_port','$send_form','$set_name')";
    $query = mysqli_query($db,$insert);
    
    if ($query) {
    $_SESSION['success'] = 'Data inserted';
} else {
    $_SESSION['errors'] = 'Something went wrong';
}

// Redirect to the same page
header("Location". $_SERVER['PHP_SELF']);

// fetch my smtp details for current user from database if available
$fetch = "SELECT * FROM `smtp-config` WHERE `user_id` = $user_id ";
$query = mysqli_query($db,$fetch);
$smtp_host = '';
$smtp_username = '';
$smtp_password = '';
$enc_type = '';
$smtp_port = '';
$send_form = '';
$set_name = '';

$button_text = "";
$button_value="";
$html = "";   
$action = "";
if($query){
    
    if(mysqli_num_rows($query) > 0 ){
        $button_text = 'update';
        $button_value = 'update';
        $html = '<div class="alert alert-warning" role="alert">
  Your SMTP Password (The saved password is not shown for security reasons. If you do not want to update the saved password, you can leave this field empty when updating other options).
</div>';
$action = 'update';
        while($row=mysqli_fetch_assoc($query)){
      $smtp_host = $row['smtp_host'];
      $smtp_username = $row['smtp_username'];
      $smtp_password = $row['smtp_password'];
      $enc_type = $row['encryption_type'];
      $smtp_port = trim($row['smtp_port']);
      $send_form = $row['send_form'];
      $set_name = $row['set_name'];
       
  }
    }else{
        $button_text = 'submit';
        $button_value = 'submit';
        $action = 'insert';
    }
   
}


    
}
}
break;
 case 'update':
//start update from here
if(isset($_POST['update'])){
    $host = trim($db -> real_escape_string($_POST['smtp_host']));
    $username = trim($db -> real_escape_string($_POST['smtp_username']));
    $password = trim($db -> real_escape_string($_POST['smtp_password']));
    $enc_type = trim($db -> real_escape_string($_POST['enc_type']));
    $smtp_port = trim($db -> real_escape_string($_POST['smtp_port']));
    $send_form = trim($db -> real_escape_string($_POST['send_form']));
    $set_name = trim($db -> real_escape_string($_POST['set_name']));
    
    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
    // validation error
    if($host == '' || $username == '' || $enc_type == '' || $send_form == '' || $smtp_port == ''||  $set_name == ''){
        $_SESSION['errors'] = 'Please fill all required fields';
    }
    else if(!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'] = 'Please provide valid email address for smtp username';
    }
    else if(!filter_var($send_form, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'] = 'Please provide valid email address for send from email';
    }else{
        // update records in database
        // if(password is present)
        if($password !=''){
         echo $update = "UPDATE `smtp-config` SET `smtp_host`='$host',`smtp_username`='$username',`smtp_password`='$password',`encryption_type`='$enc_type',`smtp_port`='$smtp_port',`send_form`='$send_form',`set_name`='$set_name' WHERE `user_id` = '$user_id' "  ;
         $update_query = mysqli_query($db,$update);
        }else{
            echo $update = "UPDATE `smtp-config` SET `smtp_host`='$host',`smtp_username`='$username',`encryption_type`='$enc_type',`smtp_port`='$smtp_port',`send_form`='$send_form',`set_name`='$set_name' WHERE `user_id` = '$user_id' "  ; 
            $update_query = mysqli_query($db,$update);
        }
        
        if($update_query){
            $_SESSION['success'] = 'Data Updated';
            
        }else{
            $_SESSION['errors'] = 'Something went wrong';
        }
        // Redirect to the same page
//header("Location". $_SERVER['PHP_SELF']);
    }
    }
    break;
    
     default:
       $_SESSION['errors'] = 'Something went wrong'; 
    break;
}
}
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>SMTP Details </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">SMTP Details</li>
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
            <h3 class="card-title">Enter your SMTP details </h3>

            
          </div>
          <!-- /.card-header -->
          <?php 
            
if(isset($_SESSION['errors'])){
?>
    <div class="alert alert-danger" role="alert">
        <?=$_SESSION['errors']?>
    </div>
<?php 
}
unset($_SESSION['errors']);
?>
<?php 
            
if(isset($_SESSION['success'])){
?>
    <div class="alert alert-success" role="alert">
        <?=$_SESSION['success']?>
    </div>
<?php 
}
unset($_SESSION['success']);
?>

          <div class="card-body">
              <form method = "post">
                  <input type="hidden" name="action" value="<?=$action?>">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>SMTP HOST <span class = "text-danger">*</span></label>
                  <input class="form-control" type="text" required name="smtp_host" value="<?php echo ($smtp_host != '') ? $smtp_host : ''; ?>">
                    </div>
                
                <div class="form-group">
                  <label>SMTP USERNAME <span class = "text-danger">*</span></label>
                  <input class="form-control" type="email" required name="smtp_username" value="<?php echo ($smtp_username != '') ? $smtp_username : ''; ?>">
                  
                </div>
                <div class="form-group">
                  <label>SMTP Password  <span class = "text-danger"></span></label>
                  <input class="form-control" type="text"  name="smtp_password" >
                </div>
                <?=$html?>
                
                <div class="form-group">
                  <label> Type of Encryption  <span class = "text-danger">*</span></label>
                  <select name="enc_type">
                  <option value="SSL" <?php echo ($enc_type == 'SSL') ? 'selected' : ''; ?>>SSL</option>
                  <option value="TLS" <?php echo ($enc_type == 'TLS') ? 'selected' : ''; ?>>TLS</option>
                </select>

                  
                </div>
                
                <div class="form-group">
                  <label> SMTP Port  <span class = "text-danger">*</span></label>
                   <input class="form-control" type="text" name="smtp_port" value="<?php echo ($smtp_port != '') ? $smtp_port : ''; ?> ">
                  </div>
                <div class="form-group">
                  <label>Send From <span class = "text-danger">*</span> </label>
                  <input class="form-control" type="email" required name="send_form" value="<?php echo ($send_form != '') ? $send_form : ''; ?>">
                  
                </div>
                <div class="form-group">
                  <label>Set Name <span class = "text-danger">*</span> </label>
                  <input class="form-control" type="text" require name="set_name" value="<?php echo ($set_name != '') ? $set_name : ''; ?>">
                  
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" name="<?=$button_text?>" value="<?=$button_value?>">
                    

                  
                </div>
                
                  
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

