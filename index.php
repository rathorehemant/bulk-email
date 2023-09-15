<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'config/db_config.php';
if(isset($_SESSION['email'])){
    header("Location: ".site_url.'dashboard.php');
}
if(isset($_POST['submit'])){
    if($_POST['email'] == '' ||$_POST['password'] == '' ){
        
    }else{
$email= mysqli_real_escape_string($db,$_POST['email']);
$password = mysqli_real_escape_string($db,$_POST['password']);

// check email is exist or not in data base
$fetch = mysqli_query($db,"SELECT  * FROM `user` WHERE email = '$email' ");
if($fetch){
    // check row count of email
  if(mysqli_num_rows($fetch)> 0){
      // extract password from db
        while($row = mysqli_fetch_array($fetch)){
            $db_name = $row['name'];
           $db_pass = $row['password'];
           $db_id =$row['id'];
           
        }      
      // check password is match or not
       if (password_verify($password, $db_pass)) {
           $_SESSION['name'] = $db_name;
            $_SESSION['email'] = $email;
            $_SESSION['uid'] = $db_id;
           header("Location: ".site_url.'dashboard.php');
       }else{
           $_SESSION['error'] = "Your password does not match for $email";
       }
  }else{
      $_SESSION['error'] = "Your email $email does not match with our database";
  } 
}else{
    $_SESSION['error'] = "Something went wrong please try after some time";
    
}
}
}
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Login</title>
    <link rel="stylesheet" href="assest/dist/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <div class="wrapper">
           <?php 
            
if(isset($_SESSION['error'])){
?>
    <div class="alert alert-danger" role="alert">
        <?=$_SESSION['error']?>
    </div>
<?php 
}
unset($_SESSION['error']);
?>

        <div class="title"><span>Login Form</span></div>
        <form method="post">
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Email" name = "email" required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name = "password" required>
          </div>
          <div class="row button">
            <input type="submit" name = "submit" value="Login">
          </div>
        </form>
      </div>
    </div>

  </body>
</html>

