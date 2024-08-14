<?php 
  require_once "class/Product.php";
  require_once "class/Database.php";
  require_once "class/Auth.php";
  require_once "class/Cart.php";

  $cartRepository = new Cart();
  
  if(!isset($_GET['id'])){
    die('Cần cung cấp thông tin sản phẩm');
  }
  $id = $_GET['id'];

  $pdo = Database::getConnect();
  $product = Sanpham::getOneById($pdo, $id);
  

  if (isset($_POST['submit_cart'])) {
    $user_id = Auth::loginWithCookie($pdo)['id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $size_ring = $_POST['size_ring'];

    if ($quantity > $product['soluongsp']) {
        echo "<script>alert('Vượt quá số lượng sản phẩm tồn kho!!!');
        window.location.href='detail.php?id=$id';</script>";
        exit;
    }

    $existingCartItem = $cartRepository->findByidUserandidSP($pdo, $user_id, $id);

    if ($existingCartItem) {
        $newQuantity = $existingCartItem['quantity'] + $quantity;
        $cartRepository->updateQuantity($pdo, $user_id, $id, $newQuantity);
    } else {
        $cartRepository->insert($pdo, $user_id, $id, $size_ring, $quantity);
    }

    header("Location: cart.php");
}
?> 
<?php 
  require_once "includes/header.php";
?>

<div class="colorlib-product py-5">
    <div class="container py-5">
        <div class="row row-pb-lg product-detail-wrap">
            <div class="col-sm-6">
                 <div class="main-img">
                <center>
                    <img id="mainImage" src="assets/images/<?=$product['hinhanh']?>" alt="ProductS" style="width:100%; max-width: 400px;">
                    <div class="row my-3 previews justify-content-center" style="width:55%">  
                        <div class="col-md-4 col-3 product-entry" style="padding:0px 5px">
                            <img id="image0" class="w-100" src="assets/images/<?=$product['hinhanh']?>" alt="Sale" style="width:100%; max-width: 100px; border: 1px solid #ddd" onclick="changeImage('assets/images/<?=$product['hinhanh']?>', 0)">
                        </div>
                        <div class="col-md-4 col-3 product-entry" style="padding:0px 5px">
                            <img id="image1" class="w-100" src="assets/images/<?=$product['hinhanh1']?>" alt="Sale" style="width:100%; max-width: 100px;border: 1px solid #ddd" onclick="changeImage('assets/images/<?=$product['hinhanh1']?>', 1)">
                        </div>
                        <div class="col-md-4 col-3 product-entry" style="padding:0px 5px">
                            <img id="image2" class="w-100" src="assets/images/<?=$product['hinhanh2']?>" alt="Sale" style="width:100%; max-width: 100px;border: 1px solid #ddd" onclick="changeImage('assets/images/<?=$product['hinhanh2']?>', 2)">
                        </div>
                    </div>
                </center>
                </div>
            </div>
            <div class="col-sm-6 py-3">
                <div class="product-desc">
                    <h2 name="tensp"><?=$product['tensp']?></h2>
                    <p name="idsp">Mã sản phẩm: <span style="color: red"><?=$product['idsp']?></span></p>
                    <p name="khuyenmai">Giảm giá: <span style="color: red"><?=$product['khuyenmai']?>%</span></p>
                    <p name="mota">Mô tả: <span><?=$product['motasp']?></span></p>
                    <p name="mota">Số lượng sản phẩm trong kho: <span style="color: red"><?=$product['soluongsp']?></span></p>
                    <p class="price">
                      <?php 
                        $product['dongia2'] = $product['dongia1'] - $product['dongia1'] * $product['khuyenmai']/100;
                      ?>
                        <span class="price-old">
                            Giá: 
                            <span style="color:red" name="dongia"><?php echo number_format($product['dongia2'], 0 ).''.'₫ ' ; ?></span>
                            <del><?php echo number_format($product['dongia1'], 0 ).''.'₫ ' ; ?></del>
                        </span>
                    </p>
                </div>
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                            <div class="Rings_size py-2">
                                <select name="size_ring" id="size_ring" class="form-select">
                                    <option value="Bạn chưa chọn size">SIZE</option>
                                    <?php
                                        $arrSize = explode(",", $product['size']);
                                        foreach ($arrSize as $size) {
                                    ?>
                                    <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                        <div class="d-flex align-items-center">
                            <span for="quantity" class="me-2" style="padding-top:10px">Số lượng mua:</span>
                            <div class="quantity"  style="width: 80%">
                                <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control">
                            </div>
                        </div>
                        </div>
                    </div>
                <div class="mt-3">
                <?php 
                    // Kiểm tra đăng nhập
                    if (Auth::loginWithCookie($pdo) || isset($_SESSION['user'])) { 
                    // Nếu đã đăng nhập, hiển thị nút thêm vào giỏ hàng
                    if ($product["soluongsp"] > 0) { 
                ?>
                    <button type="submit" name="submit_cart" class="btn btn-outline-dark">Thêm vào giỏ hàng <i class="bi bi-cart-plus"></i></button>
                <?php 
                    } else { 
                ?>
                    <button class="btn btn-outline-danger" disabled>Sản phẩm hết hàng</button>
                <?php 
                }
                } else { 
                ?>
                    <button type="button" class="btn btn-outline-dark" onclick="window.location.href='login.php'">Thêm vào giỏ hàng <i class="bi bi-cart-plus"></i></button>
                <?php
                } 
                ?>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script>
    var selectedImageIndex = 0; // Biến để lưu trữ index của ảnh được chọn
    document.getElementById("image0").style.border = "2px solid #000";
    function changeImage(imageUrl, index) {
        // Thay đổi nguồn hình ảnh của hình chính
        document.getElementById("mainImage").src = imageUrl;

        // Loại bỏ border đậm của ảnh trước đó
        document.getElementById("image" + selectedImageIndex).style.border = "1px solid #ddd";

        // Đặt border đậm cho ảnh được chọn
        document.getElementById("image" + index).style.border = "2px solid #000";

        // Cập nhật index của ảnh được chọn
        selectedImageIndex = index;
    }
</script>
<?php 
  require_once "includes/footer.php";
?>