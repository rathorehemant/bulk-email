<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config/db_config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
if (isset($_FILES['csv']) && $_FILES['csv']['error'] === UPLOAD_ERR_OK){
     $tmpName = $_FILES["csv"]["tmp_name"];
     // Check if the file has a CSV extension
    $extension = pathinfo($_FILES["csv"]["name"], PATHINFO_EXTENSION);
    if (strtolower($extension) != 'csv') {
        echo "<div class='alert alert-danger' role='alert'>
  Please upload csv file only
</div>";
       
    }else{
        if (($handle = fopen($tmpName, "r")) !== false) {
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
        //$header = preg_replace('/\s+/', '_', $header);
    }
    $headers[$index] = $header;
}
$placeholders = array();

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
}

echo  implode(", ", $placeholders);

        }
    } 
    
}
}else{
    echo "<script>window.location = '" . site_url . "';</script>";
}
?>