<?php
// Database connection
include '../lib/connection_no_class.php';

// Fetch data for total orders per year
$sql1 = "SELECT YEAR(orderDate) as year, COUNT(*) as totalOrders FROM tbl_order GROUP BY YEAR(orderDate)";
$result1 = $conn->query($sql1);

$data1 = array();
if ($result1->num_rows > 0) {
  while($row = $result1->fetch_assoc()) {
    $data1[] = array('year' => $row['year'], 'value' => $row['totalOrders']);
  }
} else {
  echo "0 results for chart 1";
}

// Fetch customer data grouped by province
$sql2 = "SELECT pr.name, COUNT(*) as customerCount 
FROM tbl_customer cs 
JOIN province pr ON cs.province = pr.province_id GROUP BY pr.name";
$result2 = $conn->query($sql2);

$data2 = array();
if ($result2->num_rows > 0) {
  while($row = $result2->fetch_assoc()) {
    $data2[] = array('label' => $row['name'], 'value' => $row['customerCount']);
  }
} else {
  echo "0 results for chart 2";
}



$conn->close();
?>

<script>
  var chartData1 = <?php echo json_encode($data1); ?>;
  var chartData2 = <?php echo json_encode($data2); ?>;
</script>