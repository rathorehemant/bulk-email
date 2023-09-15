<?php 
define('db_host','your host name');
define('db_name','your db name');
define('db_user','your db user');
define('db_pass','your db password');
define('site_url','your website url');

// Create connection
$db = new mysqli(db_host, db_user, db_pass, db_name); 
 
// Display error if failed to connect 
if ($db->connect_errno) { 
    printf("Connect failed: %s\n", $db->connect_error); 
    exit(); 
}
?>