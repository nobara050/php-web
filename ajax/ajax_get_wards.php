<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/connection_no_class.php');

?>

<?php
    $district_id = $_GET['district_id'];
    
    $sql = "SELECT * FROM `wards` WHERE `district_id` = {$district_id}";
    $resultaddress = mysqli_query($conn, $sql);


    $data[0] = [
        'id' => null,
        'name' => 'Chọn một xã/phường'
    ];

    while ($row = mysqli_fetch_assoc($resultaddress)) {
        $data[] = [
            'id' => $row['wards_id'],
            'name'=> $row['name']
        ];
    }
    echo json_encode($data);
?>