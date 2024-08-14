<?php 
require_once "../class/Auth.php";
require_once "../class/Database.php";

$db = new Database();
$pdo = $db->getConnect();
$user = Auth::getById($pdo, $_GET['user_id']);

if (isset($_POST['update'])) {
    try {
        // Kiểm tra xem có tệp ảnh mới được tải lên không
        if (!empty($_FILES['imageUser']['name'])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = mime_content_type($_FILES['imageUser']['tmp_name']);
            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception('Định dạng hình ảnh không hợp lệ. Các định dạng cho phép: JPEG, PNG, GIF.');
            }

            // Đường dẫn thư mục lưu trữ hình ảnh đã tải lên
            $targetDir = "../assets/images/imgUser/";

            // Tạo tên tệp mới dựa trên thời gian và mở rộng tệp
            $imagePath = $targetDir . basename($_FILES["imageUser"]["name"]);

            // Di chuyển tệp hình ảnh đã tải lên vào thư mục đích
            if (!move_uploaded_file($_FILES["imageUser"]["tmp_name"], $imagePath)) {
                throw new Exception('Lỗi khi tải lên hình ảnh.');
            }

            // Cập nhật đường dẫn hình ảnh mới trong cơ sở dữ liệu
            $updatedImagePath = substr($imagePath, 3); // Loại bỏ "../" để lưu đường dẫn tương đối
            Auth::updateinforUser($pdo, $_POST['fullname'], $_POST['address'], $_POST['email'], $_POST['phone'], $user['id'], $updatedImagePath);
        } else {
            // Nếu không có tệp ảnh mới, giữ nguyên đường dẫn hình ảnh hiện tại
            $updatedImagePath = $user['imageUser'];
            Auth::updateinforUser($pdo, $_POST['fullname'], $_POST['address'], $_POST['email'], $_POST['phone'], $user['id'], $updatedImagePath);
        }

        // Chuyển hướng với thông báo thành công
        header("Location: userAdmin.php");
        exit();
    } catch (Exception $e) {
        echo "<script>alert('Cập nhật người dùng thất bại: " . $e->getMessage() . "');</script>";
    }
}
?>

<?php require_once "../admin/includesAdmin/headerAdmin.php" ?>
<section class="section-bg">
    <div class="container py-5" style="max-width: 500px">
        <div class="card mb-4 p-3">
          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
            <div class="profile container" style=" text-align:center">
                <h3 class="modal-title">Thông tin cá nhân</h3>
            </div>     
                <div class="modal-body">
                    <div class="mb-3">
                         <center>
                            <img src="../<?=$user['imageUser']; ?>" alt="" width="250px" height="250px" style="border-radius: 100%; object-fit: cover;" class="lab">
                        </center>
                    </div>
                    </div>
                    <div class="mb-3">
                        <div class="text-start col-form-label"><i class="bi bi-person"></i> User name</div>
                        <div class="form-control text-start"><?php echo $user['username']; ?></div>
                        <input type="hidden" class="form-control"  name="username" value="<?php echo $user['username']; ?>" required >
                    </div>
                    <div class="mb-3">
                        <div  class="text-start col-form-label"><i class="bi bi-person"></i> Full name</div>
                        <input type="text" class="form-control"  name="fullname" value="<?php echo $user['fullname']; ?>" required>
                    </div>
                     <div class="mb-3">
                        <div class="text-start col-form-label"><i class="bi bi-envelope"></i> Email</div>
                        <input type="email" class="form-control"  name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <div  class="text-start col-form-label"><i class="bi bi-telephone"></i> Phone</div>
                        <input type="text" class="form-control"  name="phone" value="<?php echo $user['phone']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <div  class="text-start col-form-label"> <i class="bi bi-house"></i> Address</div>
                        <input type="text" class="form-control"  name="address" value="<?php echo $user['address']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Image</label>
                        <input class="form-control" type="file" name="imageUser" id="imageUser">
                        <img width="50%" id="previewImg" alt="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" value="update" name="update" class="btn btn btn-outline-dark">Cập nhật</button> 
                </div>
            </form>
          </div>
        </div>
    </div>
</section>
<?php require_once "../admin/includesAdmin/footerAdmin.php" ?>
