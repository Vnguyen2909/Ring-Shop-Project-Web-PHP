<?php 
require_once "../class/Auth.php";
require_once "../class/Database.php";
require_once "../class/Loaisanpham.php";

$db = new Database();
$pdo = $db->getConnect();
$loaisanpham = Loaisanpham::getAllLoaiSP(Database::getConnect());

if(isset($_POST['addproduct'])) {
    $tensp = $_POST['tensp'];
    $motasp = $_POST['mota'];
    $dongia1 = $_POST['dongia'];
    $khuyenmai = $_POST['khuyenmai'];
    $size = $_POST['size'];
    $idLSP = $_POST['loaisanpham'];
    $tenthuonghieu = $_POST['tenthuonghieu'];
    $soluongsp = $_POST['soluong'];

    $hinhanh = $_FILES['hinhanh']['name'];
    $hinhanh1 = $_FILES['hinhanh1']['name'];
    $hinhanh2 = $_FILES['hinhanh2']['name'];

    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
    $hinhanh1_tmp = $_FILES['hinhanh1']['tmp_name'];
    $hinhanh2_tmp = $_FILES['hinhanh2']['tmp_name'];

    move_uploaded_file($hinhanh_tmp,  "assets/images/$hinhanh");
    move_uploaded_file($hinhanh1_tmp, "assets/images/$hinhanh1");
    move_uploaded_file($hinhanh2_tmp, "assets/images/$hinhanh2");

    $success = Sanpham::addProduct($pdo, $tensp, $motasp, $dongia1, $hinhanh, $hinhanh1, $hinhanh2, $khuyenmai, $size, $idLSP, $tenthuonghieu, $soluongsp);

    if($success) {
        echo "<script>alert('Sản phẩm đã được thêm!');</script>";
    } else {
        echo "<script>alert('Thêm sản phẩm thất bại!!!');</script>";
    }
}
?>
<?php require_once "../admin/includesAdmin/headerAdmin.php"; ?>
<section class="section-bg">
    <div class="container py-5" style="max-width: 800px">
        <div class="card mb-4 p-3">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="profile container" style=" text-align:center">
                        <h3 class="modal-title">Thêm sản phẩm</h3>
                    </div>     
                    <div class="mb-3">
                        <div class="text-start col-form-label"><i class="bi bi-person"></i> Tên sản phẩm</div>
                        <input type="text" class="form-control"  name="tensp" value="" required >
                    </div>
                    <div class="mb-3">
                        <div  class="text-start col-form-label"> <i class="bi bi-house"></i> Loại sản phẩm</div>
                        <select name="loaisanpham" id="loaisanpham" class="form-select" aria-label="Default select example">
                            <option value="0">Chọn loại sản phẩm</option>
                            <?php foreach($loaisanpham as $lsp): ?>
                                <option value="<?= $lsp->idLoaiSP ?>"><?= $lsp->tenloaisanpham ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="text-start col-form-label"><i class="bi bi-person"></i> Mô tả</div>
                        <textarea class="form-control" name="mota" required></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="text-start col-form-label"><i class="bi bi-envelope"></i> Đơn giá (VNĐ)</div>
                        <input type="number" class="form-control"  name="dongia" value="" required>
                    </div>
                    <div class="mb-3">
                        <div  class="text-start col-form-label"><i class="bi bi-telephone"></i>Khuyến mãi (%) </div>
                        <input type="text" class="form-control"  name="khuyenmai" value="" required>
                    </div>
                    <div class="mb-3">
                        <div  class="text-start col-form-label"> <i class="bi bi-house"></i> Size</div>
                        <input type="text" class="form-control"  name="size" value="" required>
                    </div>
                    <div class="mb-3">
                        <div  class="text-start col-form-label"> <i class="bi bi-house"></i> Tên thương hiệu</div>
                        <input type="text" class="form-control"  name="tenthuonghieu" value="" required>
                    </div>
                    <div class="mb-3">
                        <div  class="text-start col-form-label"> <i class="bi bi-house"></i> Số lượng sản phẩm</div>
                        <input type="text" class="form-control"  name="soluong" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Hình ảnh 1</label>
                        <input class="form-control" type="file" name="hinhanh" id="hinhanh">
                        <img width="50%" id="previewImg" alt="">
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Hình ảnh 2</label>
                        <input class="form-control" type="file" name="hinhanh1" id="hinhanh1">
                        <img width="50%" id="previewImg" alt="">
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Hình ảnh 3</label>
                        <input class="form-control" type="file" name="hinhanh2" id="hinhanh2">
                        <img width="50%" id="previewImg" alt="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" value="addproduct" name="addproduct" class="btn btn btn-outline-dark">Thêm sản phẩm</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require_once "../admin/includesAdmin/footerAdmin.php" ?>
