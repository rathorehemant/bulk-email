<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('vendor/smtp/PHPMailerAutoload.php');
include 'config/db_config.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email_subject = $_POST['email_subject'];
     // The request is using the POST method

// fetch my smtp details for current user from database if available for update dynamic smtp configuration
// $user_id = $_SESSION['uid'];
// $smtp_host = '';
//       $smtp_username = '';
//       $smtp_password = '';
//       $enc_type = '';
//       $smtp_port = '';
//       $send_form = '';
//       $set_name = '';
// $fetch = "SELECT * FROM `smtp-config` WHERE `user_id` = $user_id ";
// $query = mysqli_query($db,$fetch);

// if($query){
//   while($row=mysqli_fetch_assoc($query)){
//       $smtp_host = $row['smtp_host'];
//       $smtp_username = $row['smtp_username'];
//       $smtp_password = $row['smtp_password'];
//       $enc_type = $row['encryption_type'];
//       $smtp_port = trim($row['smtp_port']);
//       $send_form = $row['send_form'];
//       $set_name = $row['set_name'];
       
//   }
// }
if (isset($_FILES['csv']) && $_FILES['csv']['error'] === UPLOAD_ERR_OK){
    
    $tmpName = $_FILES["csv"]["tmp_name"];
    // Check if the file has a CSV extension
    $extension = pathinfo($_FILES["csv"]["name"], PATHINFO_EXTENSION);
   
    if (strtolower($extension) != 'csv') {
        echo "<div class='alert alert-danger' role='alert'>
  Please upload csv file only
</div>";
        
    } else {
        // Open the CSV file for reading
        if (($handle = fopen($tmpName, "r")) !== false) {
           $row_count = count(file($tmpName)) - 1; // Subtract 1 to exclude header row
     
            
            // Loop through each row of the CSV file
            $headers = fgetcsv($handle, 0, ",");
            $headerCounts = array();

foreach($headers as $index => $header) {
    if(empty($header)){
        $header = 'unnamed';
        if (isset($headerCounts[$header])) {
            $headerCounts[$header]++;
            $header = 'unnamed_'.$headerCounts[$header];
        } else {
            $headerCounts[$header] = 1;
           $header = 'unnamed_'.$headerCounts[$header];
        }
    }else{
        $header = preg_replace('/\s+/', '_', $header);
        $header = rtrim($header, "_");
        $header = strtolower($header);
    }
    $headers[$index] = $header;
}
            
           // Check if the user has selected a valid email field placeholder
        //   echo '------for header------';
        //   echo '<pre>';
        //   print_r($headers);
        //   echo '</pre>';
        //   echo '-------- for post filed----';
        //   echo '</br>';
        //   echo '<pre>';
        //   print_r($_POST);
        //   echo '</pre>';
        //   die();
            
            
                
                $successCount = 0;
                while (($data = fgetcsv($handle, 0, ",")) !== false) {
                    // Create email content with all CSV values
                    $name = $data[array_search('name', $headers)];
                    $email = $data[array_search('email', $headers)];
                    
                    $emailContent = "Hello $name, <br><br>Here are your details:<br><br>";
                    
                    $headerCounts = array();
                    $placeholders = array();
                    $email_template = $_POST['editor1'];
                    foreach($headers as $index => $header) {
                        $headerName = strtolower(trim($header));
                       $headerName = str_replace(' ', '_', $headerName); // Add underscore in place of spaces
                        if (isset($headerCounts[$headerName])) {
                        $headerCounts[$headerName]++;
                        $headerName .= '_'.$headerCounts[$headerName];
                    } else {
                        $headerCounts[$headerName] = 1;
                    }
                        $value = isset($data[$index]) ? $data[$index] : "";
                        $placeholder = "{{" . $headerName . "}}";
                         array_push($placeholders, $placeholder);
                        $email_template = str_ireplace($placeholder, $value, $email_template);
                    }
                    $emailPlaceholder =  $_POST['email_field'];
      
if (!in_array($emailPlaceholder, $placeholders)) {
    echo "<div class='alert alert-danger' role='alert'>
  Invalid email field placeholder selected
</div>";
   
    exit();
}else{
                    
                    $emailContent .= "<br>" . $email_template;
}      


                    
                    // Create a new PHPMailer instance for each recipient
                    $mail = new PHPMailer(true); 
                    try {
                        $mail->isSMTP();
                        $mail->SMTPDebug = 0;
                        $mail->SMTPAuth = true; 
                        $mail->SMTPSecure = 'SSL';
                        $mail->Host = 'your email host';
                        $mail->Port = 'enter your port number'; 
                        $mail->Username = 'smtp user name';
                        $mail->Password = 'smtp password';
                        $mail->setFrom('set from email', 'set from name eg admin etc');
                        $mail->addAddress($data[array_search($emailPlaceholder, $placeholders)], $data[array_search('name', $headers)]);
                        $mail->isHTML(true); 
                        $mail->Subject = $email_subject;
                        $mail->Body = $emailContent;
                        $mail->send();
                        $successCount++;
                    } catch (Exception $e) {
                         echo "<div class='alert alert-danger' role='alert'>
  Message could not be sent to {$data[array_search('email', $headers)]}. Mailer Error: {$mail->ErrorInfo}
</div>";
                        
                    }
                }
                 if ($successCount == $row_count) {
                        echo "<div class='alert alert-success' role='alert'>
  All email sent successfully.
</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>
  Some mails are not send
</div>";
                    }
            
            // Close the file handle
            fclose($handle);
        } else {
             echo "<div class='alert alert-danger' role='alert'>
  Error reading file
</div>";
            
        }
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>
  Error uploading file
</div>";
    
}
}else{
   
    echo "<script>window.location = '" . site_url . "';</script>";


}
?>
