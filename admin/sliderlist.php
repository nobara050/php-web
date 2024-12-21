<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Slider</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/slider.css">
</head>
<body>
<?php 
  include 'inc/header.php'; 
  require_once '../classes/Product.php'; 
?>
<?php 
  $product = new Product();
  if (isset($_GET['del_slider'])) {
    $id = $_GET['del_slider'];
    $type = isset($_GET['type']) ? $_GET['type'] : null;
    $del_slider = $product->del_slider($id);
  }

  if (isset($_GET['type_slider']) && isset($_GET['type'])) {
    $id = $_GET['type_slider'];
    $type = $_GET['type'];
    $update_type_slider = $product->update_type_slider($id, $type);
  }
?>
    <h1 class="dashboard-title">Danh sách Banner</h1>
    <div class="grid_10">
        <div class="box round first grid">
            <h2>Slider List</h2>
            <div class="block">
                <table class="dataTable" id="sliderTable">
                    <thead>
                        <tr>
                            <th style="width: 8%;">No.</th>
                            <th style="width: 20%;">Title</th>
                            <th style="width: 15%;">Image</th>
                            <th style="width: 8%;">Type</th>
                            <th style="width: 25%;">Action</th>
                        </tr>
                    </thead>         
                    <tbody>
                        <?php 
                            $product = new Product();
                            $get_slider = $product->show_slider();
                            if ($get_slider) {
                                $i = 0;
                                while ($result_slider = $get_slider->fetch_assoc()) {
                                    $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($result_slider['sliderName']); ?></td>
                            <td>
                                <img src="upload/<?php echo htmlspecialchars($result_slider['sliderImage']); ?>" height="60px" width="60px" alt="">
                            </td>
                            <td>
                                <?php if($result_slider['sliderType'] == 1) { ?>
                                    <a href="?type_slider=<?php echo $result_slider['sliderID']; ?>&type=0">Off</a>
                                <?php } else { ?>
                                    <a href="?type_slider=<?php echo $result_slider['sliderID']; ?>&type=1">On</a>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="edit_slider.php?id=<?php echo $result_slider['sliderID']; ?>">Edit</a> |
                                <a href="#" onclick="confirmDelete(<?php echo $result_slider['sliderID']; ?>); return false;">Delete</a>
                            </td>
                        </tr>
                        <?php
                                }
                            } else {
                                echo '<tr><td colspan="5">No sliders found.</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
      function confirmDelete(id) {
        Swal.fire({
          title: 'Bạn có chắc là muốn xóa?',
          text: "Bạn sẽ không thể hoàn tác hành động này!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Có, xóa nó!',
          cancelButtonText: 'Hủy'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = '?del_slider=' + id;
          }
        });
      }

      $(document).ready(function() {
        setupLeftMenu();
        $(".datatable").dataTable();
        setSidebarHeight();
      });
    </script>

    <?php 
      include 'inc/footer.php'; 
    ?>
</body>
</html>