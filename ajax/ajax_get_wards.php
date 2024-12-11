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

    $district_id = $_GET['district_id'];

    // echo $district_id;
    
    $sql = "SELECT * FROM `wards` WHERE `district_id` = {$district_id}";
    $result = mysqli_query($conn, $sql);


    $data[0] = [
        'id' => null,
        'name' => 'Chọn một xã/phường'
    ];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => $row['wards_id'],
            'name'=> $row['name']
        ];
    }
    echo json_encode($data);
?>