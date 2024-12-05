<?php 
  include 'inc/header.php'; 
  include '../classes/brand.php';
  include '../classes/category.php';
  include '../classes/product.php';
  include_once '../helpers/format.php';
?>

<?php 
  $pd = new product();
  $fm = new Format();
?>
  <link rel="stylesheet" href="css/productlist.css">
      <h1 class="dashboard-title">Danh sách sản phẩm</h1>
      <div class="container">
        <div class="box product-list-box">
            <div class="table-container">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Hình ảnh</th>
                            <th>Danh mục</th>
                            <th>Thương hiệu</th>
                            <th>Độ đo</th>
                            <th>Trưng bày</th>
                            <th>Tùy chỉnh</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $pdlist = $pd->show_product();
                        if($pdlist) {
                          $i = 0;
                          while($result = $pdlist->fetch_assoc()){
                            $i++;
                      ?>
                        <tr class="product-row">
                            <td><?php echo $i ?></td>
                            <td><?php echo $result['productName'] ?></td>
                            <td><?php echo $result['price'] ?>đ</td>
                            <td><img class="product-image" src="./upload/<?php echo $result['image'] ?>" alt=""></td>
                            <td><?php echo $result['catName'] ?></td>
                            <td><?php echo $result['brandName'] ?></td>
                            <!-- ================================================= -->
                            <td>
                                <?php
                                // Lấy các độ đo từ bảng tbl_measure
                                $measures = $pd->get_measures_by_product($result['productId']);
                                if ($measures) {
                                    while ($measure = $measures->fetch_assoc()) {
                                        // Hiển thị từng độ đo
                                        echo "<div class='measure-item'><span>";
                                        echo $measure['measureName'] . ": " . $measure['measureValue'];
                                        echo "</span></div>";
                                    }
                                } else {
                                    echo "<span>Không có độ đo</span>";
                                }
                                ?>
                            </td>
                            <!-- ================================================= -->

                            <td>
                              <?php 
                              if($result['type'] == 1) {
                                echo 'Có';
                              } else {
                                echo 'Không';
                              }
                              ?></td>
                            <td>
                              <a href="productedit.php?productid=<?php echo $result['productId'] ?>">Edit</a> 
                              | 
                              <a href="productedit.php?productid=<?php echo $result['productId'] ?>">Delete</a>
                            </td>
                        </tr>
                      <?php 
                          }
                        }
                      ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
      

<?php 
  include 'inc/footer.php'; 
?>

