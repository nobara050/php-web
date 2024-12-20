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

// Fetch data for total revenue per year
$sql2 = "SELECT productName, quantity as year, SUM(totalAmount) as totalRevenue FROM tbl_order GROUP BY YEAR(orderDate)";
$result2 = $conn->query($sql2);

$data2 = array();
if ($result2->num_rows > 0) {
  while($row = $result2->fetch_assoc()) {
    $data2[] = array('year' => $row['year'], 'value' => $row['totalRevenue']);
  }
} else {
  echo "0 results for chart 2";
}

// Fetch data for average order value per year
$sql3 = "SELECT YEAR(orderDate) as year, AVG(totalAmount) as avgOrderValue FROM tbl_order GROUP BY YEAR(orderDate)";
$result3 = $conn->query($sql3);

$data3 = array();
if ($result3->num_rows > 0) {
  while($row = $result3->fetch_assoc()) {
    $data3[] = array('year' => $row['year'], 'value' => $row['avgOrderValue']);
  }
} else {
  echo "0 results for chart 3";
}

// Fetch data for total orders per month for the year 2023
$sql4 = "SELECT MONTH(orderDate) as month, COUNT(*) as totalOrders FROM tbl_order WHERE YEAR(orderDate) = 2023 GROUP BY MONTH(orderDate)";
$result4 = $conn->query($sql4);

$data4 = array();
if ($result4->num_rows > 0) {
  while($row = $result4->fetch_assoc()) {
    $data4[] = array('month' => $row['month'], 'value' => $row['totalOrders']);
  }
} else {
  echo "0 results for chart 4";
}

$conn->close();
?>

<script>
  var chartData1 = <?php echo json_encode($data1); ?>;
  var chartData2 = <?php echo json_encode($data2); ?>;
  var chartData3 = <?php echo json_encode($data3); ?>;
  var chartData4 = <?php echo json_encode($data4); ?>;
</script>