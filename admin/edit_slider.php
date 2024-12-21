<?php
include 'inc/header.php';
require_once '../classes/Product.php';

$product = new Product();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $slider = $product->get_slider_by_id($id);
    if ($slider) {
        $slider = $slider->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_slider'])) {
    $sliderName = $_POST['sliderName'];
    $sliderType = $_POST['sliderType'];
    $sliderImage = $_FILES['sliderImage']['name'];
    $tmp_name = $_FILES['sliderImage']['tmp_name'];

    if ($sliderImage) {
        move_uploaded_file($tmp_name, "upload/$sliderImage");
    } else {
        $sliderImage = $slider['sliderImage'];
    }

    $update_slider = $product->update_slider($id, $sliderName, $sliderType, $sliderImage);
    if ($update_slider) {
        header('Location: sliderlist.php');
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Slider</title>
    <link rel="stylesheet" href="css/slider.css">
</head>
<body>
    <h1 class="dashboard-title">Chỉnh sửa Slider</h1>
    <div class="grid_10">
        <div class="box round first grid">
            <h2>Edit Slider</h2>
            <div class="block">
                <form action="" method="post" enctype="multipart/form-data">
                    <table class="form">
                        <tr>
                            <td>
                                <label>Title</label>
                            </td>
                            <td>
                                <input type="text" name="sliderName" value="<?php echo htmlspecialchars($slider['sliderName']); ?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Type</label>
                            </td>
                            <td>
                                <select name="sliderType">
                                    <option value="1" <?php if ($slider['sliderType'] == 1) echo 'selected'; ?>>On</option>
                                    <option value="0" <?php if ($slider['sliderType'] == 0) echo 'selected'; ?>>Off</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Image</label>
                            </td>
                            <td>
                                <input type="file" name="sliderImage" />
                                <img src="upload/<?php echo htmlspecialchars($slider['sliderImage']); ?>" height="60px" width="60px" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" name="update_slider" value="Update" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <?php include 'inc/footer.php'; ?>
</body>
</html>