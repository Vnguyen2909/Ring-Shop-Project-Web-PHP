<?php
require_once "../class/Database.php";
require_once "../class/Sanpham.php";

// Lấy dữ liệu sản phẩm
$db = new Database();
$pdo = $db->getConnect();

$product_id = $_GET['idsp'];
$product = Sanpham::getOneById($pdo, $product_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    try{
        $tensp = $_POST['tensp'];
        $motasp = $_POST['motasp'];
        $dongia1 = $_POST['dongia1'];
        $khuyenmai = $_POST['khuyenmai'];
        $tenthuonghieu = $_POST['tenthuonghieu'];
        $soluongsp = $_POST['soluongsp'];
    
        $imageUser = $_FILES['hinhanh']['name'];
        $hinhanh1 = $_FILES['hinhanh1']['name'];
        $hinhanh2 = $_FILES['hinhanh2']['name'];
    
        // Cập nhật hình ảnh chính
        if ($imageUser) {
            $target_dir = "../assets/images/";
            $target_file = $target_dir . basename($imageUser);
            move_uploaded_file($_FILES['hinhanh']['tmp_name'], $target_file);
        } else {
            $imageUser = $product['hinhanh'];
        }
    
        // Cập nhật hình ảnh thứ hai
        if ($hinhanh1) {
            $target_dir1 = "../assets/images/";
            $target_file1 = $target_dir1 . basename($hinhanh1);
            move_uploaded_file($_FILES['hinhanh1']['tmp_name'], $target_file1);
        } else {
            $hinhanh1 = $product['hinhanh1'];
        }
    
        // Cập nhật hình ảnh thứ ba
        if ($hinhanh2) {
            $target_dir2 = "../assets/images/";
            $target_file2 = $target_dir2 . basename($hinhanh2);
            move_uploaded_file($_FILES['hinhanh2']['tmp_name'], $target_file2);
        } else {
            $hinhanh2 = $product['hinhanh2'];
        }
    
        Sanpham::updateProduct($pdo, $product_id, $tensp, $tenthuonghieu, $motasp, $dongia1, $soluongsp, $khuyenmai, $imageUser, $hinhanh1, $hinhanh2);
        echo "<script>alert('Sản phẩm cập nhật thành công!');</script>";
        header('Location: productAdmin.php');
        exit;
    }catch (Exception $e) {
        echo "<script>alert('Cập nhật sản phẩm thất bại!!!');</script>";
    }
    
}
?>
<?php require_once "../admin/includesAdmin/headerAdmin.php"; ?>
<section class="section-bg">
    <div class="container py-5" style="max-width: 500px">
        <div class="card mb-4 p-3">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="profile container" style="text-align:center">
                        <h3 class="modal-title">Chỉnh sửa sản phẩm</h3>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <center>
                                <img src="../assets/images/<?= $product['hinhanh'] ?>" alt="Product Image" width="250px" height="250px" style="border-radius: 100%; object-fit: cover;" class="lab">
                            </center>
                        </div>
                        <div class="mb-3">
                            <div class="text-start col-form-label">Tên sản phẩm</div>
                            <input type="text" class="form-control" name="tensp" value="<?= $product['tensp'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <div class="text-start col-form-label">Thương hiệu</div>
                            <input type="text" class="form-control" name="tenthuonghieu" value="<?= $product['tenthuonghieu']?>" required>
                        </div>
                        <div class="mb-3">
                            <div class="text-start col-form-label">Mô tả sản phẩm</div>
                            <textarea class="form-control" name="motasp" required><?= $product['motasp'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="text-start col-form-label">Đơn giá</div>
                            <input type="text" class="form-control" name="dongia1" value="<?= $product['dongia1'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <div class="text-start col-form-label">Số lượng</div>
                            <input type="text" class="form-control" name="soluongsp" value="<?= $product['soluongsp'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <div class="text-start col-form-label">Khuyến mãi</div>
                            <input type="text" class="form-control" name="khuyenmai" value="<?= $product['khuyenmai'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">Hình ảnh 1 sản phẩm</label>
                            <input class="form-control" type="file" name="hinhanh" id="hinhanh">
                            <img width="50%" id="previewImg" alt="">
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">Hình ảnh 2 sản phẩm</label>
                            <input class="form-control" type="file" name="hinhanh1" id="hinhanh1">
                            <img width="50%" id="previewImg1" alt="">
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">Hình ảnh 3 sản phẩm</label>
                            <input class="form-control" type="file" name="hinhanh2" id="hinhanh2">
                            <img width="50%" id="previewImg2" alt="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="update" class="btn btn-outline-dark">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require_once "../admin/includesAdmin/footerAdmin.php"; ?>
