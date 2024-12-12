<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../config/config.php');

?>

<?php 
    $host = DB_HOST; 
    $username = DB_USER; 
    $password = DB_PASS; 
    $dbname = DB_NAME;  
    
    // Create connection
    $conn = mysqli_connect($host, $username, $password, $dbname);
    
    // Kiểm tra kết nối
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
?>