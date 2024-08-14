<?php
  require_once "class/Database.php";
  require_once "class/Auth.php";
  require_once "class/Cart.php";

  $pdo = Database::getConnect();

  $cartRepository = new Cart();

  $infoUser = Auth::loginWithCookie($pdo);

  // var_dump($productID);
  if (isset($_POST['update'])) {
    try {
        // Xử lý tải lên hình ảnh
        $imagePath = $infoUser['imageUser']; // Giữ hình ảnh hiện tại nếu không có hình ảnh mới được tải lên
        if (!empty($_FILES['imageUser']['name'])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = mime_content_type($_FILES['imageUser']['tmp_name']);
            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception('Định dạng hình ảnh không hợp lệ. Các định dạng cho phép: JPEG, PNG, GIF.');
            }
            // Đường dẫn lưu trữ tệp hình ảnh
            $targetDir = "assets/images/imgUser/";
            $imagePath = $targetDir . basename($_FILES["imageUser"]["name"]);
            if (!move_uploaded_file($_FILES["imageUser"]["tmp_name"], $imagePath)) {
                throw new Exception('Lỗi khi tải lên hình ảnh.');
            }
        }

        Auth::updateinforUser($pdo, $_POST['fullname'], $_POST['address'], $_POST['email'], $_POST['phone'], $infoUser['id'], $imagePath);
        echo "<script>alert('Cập nhật thông tin thành công!');
        window.location.href='profile.php';</script>";
        exit();
    } catch (Exception $e) {
        echo "<script>alert('Cập nhật thông tin thất bại!!!');
        window.location.href='profile.php';</script>";
    }
}

?>
<?php
  require_once "includes/header.php";
?>

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
                            <img src="<?php echo $infoUser['imageUser']; ?>" alt="" width="250px" height="250px" style="border-radius: 100%; object-fit: cover;" class="lab">
                        </center>
                    </div>
                    </div>
                    <div class="mb-3">
                        <div class="text-start col-form-label"><i class="bi bi-person"></i> User name</div>
                        <div class="form-control text-start"><?php echo $infoUser['username']; ?></div>
                        <input type="hidden" class="form-control"  name="username" value="<?php echo $infoUser['username']; ?>" required >
                    </div>
                    <div class="mb-3">
                        <div  class="text-start col-form-label"><i class="bi bi-person"></i> Full name</div>
                        <input type="text" class="form-control"  name="fullname" value="<?php echo $infoUser['fullname']; ?>" required>
                    </div>
                     <div class="mb-3">
                        <div class="text-start col-form-label"><i class="bi bi-envelope"></i> Email</div>
                        <input type="email" class="form-control"  name="email" value="<?php echo $infoUser['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <div  class="text-start col-form-label"><i class="bi bi-telephone"></i> Phone</div>
                        <input type="text" class="form-control"  name="phone" value="<?php echo $infoUser['phone']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <div  class="text-start col-form-label"> <i class="bi bi-house"></i> Address</div>
                        <input type="text" class="form-control"  name="address" value="<?php echo $infoUser['address']; ?>" required>
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

<?php
  require_once "includes/footer.php";
?>