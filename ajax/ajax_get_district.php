<?php 

    // Replace with your MySQL server settings
    $host = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "website_mvc"; 
    
    // Create connection
    $conn = mysqli_connect($host, $username, $password, $dbname);
    
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    
    // echo "Connected successfully!";
    
    $province_id = $_GET['province_id'];
    
    $sql = "SELECT * FROM `district` WHERE `province_id` = {$province_id}";
    $result = mysqli_query($conn, $sql);

    $data[0] = [
        'id' => null,
        'name' => 'Chọn một Quận/huyện'
    ];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => $row['district_id'],
            'name'=> $row['name']
        ];
    }
    echo json_encode($data);
?>