<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <style>
    .chart-container {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
    }
    .chart {
      width: 45%;
      min-width: 300px;
      margin: 20px 0;
    }
  </style>
</head>
<body>
  
</body>
</html>

<?php 
  include 'inc/header.php';
  include 'dashboard.php';
  include 'dashboard.php'; 
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<style>
  .chart-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
  }
  .chart {
    width: 45%;
    min-width: 300px;
    margin: 20px 0;
  }
</style>
      <h1 class="dashboard-title">Dashboard</h1>
      <p>Chào mừng bạn đến với trang quản trị!</p>
      <div class="chart-container">
        <div class="chart">
          <p>Thống kê năm và tổng số tiền:</p>
          <div id="linechart" style="height: 250px;"></div>
        </div>
        <div class="chart">
          <p>Thống kê số lượng khách hàng của mỗi tỉnh:</p>
          <div id="customerChart" style="height: 250px;"></div>
        </div>
      </div>
      <div class="chart-container">
        <div class="chart">
          <p>Thống kê năm và tổng số tiền:</p>
          <div id="linechart" style="height: 250px;"></div>
        </div>
        <div class="chart">
          <p>Thống kê số lượng khách hàng của mỗi tỉnh:</p>
          <div id="customerChart" style="height: 250px;"></div>
        </div>
      </div>

  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <!-- Biểu đồ thống kê đơn hàng dạng đường (line chart) -->
  <script>
    new Morris.Line({
      // ID of the element in which to draw the chart.
      element: 'linechart',
      // Chart data records -- each entry in this array corresponds to a point on
      // the chart.
      data: chartData1,
      // The name of the data record attribute that contains x-values.
      xkey: 'year',
      // A list of names of data record attributes that contain y-values.
      ykeys: ['value'],
      // Labels for the ykeys -- will be displayed when you hover over the
      // chart.
      labels: ['Value']
    });
  </script>

  <!-- Biểu đồ thống kê số lượng khách hàng theo tỉnh (donut chart biểu đồ tròn) -->
 <script>
    new Morris.Donut({
      // ID of the element in which to draw the chart.
      element: 'customerChart',
      // Chart data records -- each entry in this array corresponds to a point on
      // the chart.
      data: chartData2,
      formatter: function (x) { return x + " khách hàng"}
    });
  </script>
<?php 
  include 'inc/footer.php'; 
?>
