<?php 
session_start();
include 'config/db_config.php';
session_destroy();
echo "<script>
window.location.href = '" . site_url . "';
</script>";

?>