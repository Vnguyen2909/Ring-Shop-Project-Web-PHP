<?php
require_once "class/Product.php";
require_once "class/Database.php";
require_once "class/Auth.php";
require_once "class/Cart.php";
require_once "class/Orders.php";

$pdo = Database::getConnect();

$cartRepository = new Cart();
$order = new Orders();

$infoUser = Auth::loginWithCookie($pdo);
$cartList = $cartRepository->findByidUser($pdo, $infoUser['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update_cart'])) {
      $productId = intval($_POST['product_id']);
      $quantity = intval($_POST['quantity']);
      
      // Fetch product details to get the available stock quantity
      $product = Sanpham::getOneById($pdo, $productId);
      
      // Check if requested quantity exceeds available stock
      if ($quantity > $product['soluongsp']) {
          echo "<script>alert('Vượt quá số lượng sản phẩm tồn kho!!!');
          window.location.href='cart.php';</script>";
          exit;
      }

      // Update cart quantity if within available stock
      $cartRepository->updateQuantity($pdo, $infoUser['id'], $productId, $quantity);
      header('Location: ' . $_SERVER['PHP_SELF']);
      exit;
  }

    if (isset($_POST['remove_product'])) {
        $productId = intval($_POST['product_id']);
        $cartRepository->deleteByidUserandidSP($pdo, $infoUser['id'], $productId);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<?php require_once "includes/header.php"; ?>

<section class="h-100 h-custom" style="padding-bottom: 0">
    <div class="container h-100 py-5">
        <div class="row d-flex justify-content-center align-items-center h-100 shopping-cart">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" style="width: 100%; max-width: 100%;">
                        <thead>
                          <tr>
                             <th>All Products</th>
                             <th></th>
                             <th>Price</th>
                             <th>Sale</th>
                             <th>Size</th>
                             <th>Quantity</th>
                             <th>Total</th>
                             <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                            $sumPrice = 0;
                            $total = 0;
                            $shipPrice = 0;
                            foreach ($cartList as $cart) {
                                $product = Sanpham::getOneById($pdo, $cart['idSPcart']);
                                $product['dongia2'] = ($product['dongia1'] - ($product['dongia1'] * $product['khuyenmai'] / 100)) * $cart['quantity'];
                                $sumPrice += $product['dongia2'];
                          ?>
                          <tr>
                            <td><img width="100" class="mr-15" src="assets/images/<?= $product['hinhanh1'] ?>"></td>
                            <td class="align-middle"><?= $product['tensp'] ?></td>
                            <td class="align-middle"><?= number_format($product['dongia1'], 0) . ' VNĐ'; ?></td>
                            <td class="align-middle"><?= $product['khuyenmai'] ?>%</td>
                            <td class="align-middle"><?= $cart['ring_size'] ?></td>
                            <td class="align-middle" style="width:7%">
                              <form method="POST" action="">
                                <input type="hidden" name="product_id" value="<?= $product['idsp'] ?>">
                                <input type="number" name="quantity" value="<?= $cart['quantity'] ?>" min="1" class="form-control">
                            </td>
                            <td class="align-middle"><?= number_format($product['dongia2'], 0) . ' VNĐ'; ?></td>
                            <td class="align-middle">
                                <button type="submit" name="update_cart" class="btn btn-outline-dark">Update</button>
                                <button type="submit" name="remove_product" class="btn btn-outline-dark">Remove</button>
                              </form>
                            </td>
                          </tr>
                          <?php
                              $count++;
                            }
                            $shipPrice = ($count >= 3) ? 0 : 35000;
                            $total = $sumPrice + $shipPrice;
                          ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="hero d-flex align-items-center section-bg p-5">
  <div class="container p-0">
    <div class="row bg-white rounded shadow-sm">
      <div class="col-lg-6">
        <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Billing Detail</div>
        <div class="p-4">
          <div class="form-group p-2">
            <label>Full Name<span>*</span></label>
            <input readonly value="<?= ($infoUser['fullname']) ?>" class="form-control" type="text">
          </div>
          <div class="form-group p-2">
            <label>Email Address<span>*</span></label>
            <input readonly value="<?= ($infoUser['email']) ?>" class="form-control" type="email">
          </div>
          <div class="form-group p-2">
            <label>Phone<span>*</span></label>
            <input readonly value="<?= ($infoUser['phone']) ?>" class="form-control" type="text">
          </div>
          <div class="form-group p-2">
            <label>Address<span>*</span></label>
            <input readonly value="<?= ($infoUser['address']) ?>" class="form-control" type="text">
          </div>
        </div>
        <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instructions for seller</div>
        <div class="p-4">
          <p class="font-italic mb-4">If you have any specific information for us, you can leave it in the box below</p>
          <textarea name="seller_notes" cols="30" rows="2" class="form-control"></textarea>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Order summary</div>
        <div class="p-4">
          <p class="font-italic mb-4">Shipping and additional costs are calculated based on the values you have entered. Buy 3 or more products for <span style="color:red">Free Shipping</span></p>
          <ul class="list-unstyled mb-4">
            <li class="d-flex justify-content-between py-3 border-bottom">
              <strong class="text-muted">Order Subtotal</strong>
              <strong style="color:red"><?= number_format($sumPrice, 0, ',', '.') ?> VNĐ</strong>
            </li>
            <li class="d-flex justify-content-between py-3 border-bottom">
              <strong class="text-muted">Shipping and handling</strong>
              <strong><?= number_format($shipPrice, 0, ',', '.'); ?> VNĐ</strong>
            </li>
            <li class="d-flex justify-content-between py-3 border-bottom">
              <strong class="text-muted">Total</strong>
              <h5 class="font-weight-bold"><?= number_format($total, 0, ',', '.') ?> VND</h5>
            </li>
          </ul>
        </div>
        <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Payment Method</div>
        <div class="p-4">
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="radio" id="rdo01" name="payment" value="cheque" checked>
              <label class="form-check-label" for="rdo01">Cheque Payment</label>
              <p class="mt-2">Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="radio" id="rdo02" name="payment" value="cod">
              <label class="form-check-label" for="rdo02">Cash on Delivery</label>
              <p class="mt-2">Please keep an eye on your phone and shipping address information so that we can contact you!!!</p>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="payment" id="rdo03" value="paypal">
              <label class="form-check-label" for="rdo03">Paypal</label>
            </div>
            <ul class="list-inline mt-2">
              <li class="list-inline-item"><a href="#"><img src="assets/images/pay1.png" alt=""></a></li>
              <li class="list-inline-item"><a href="#"><img src="assets/images/pay2.png" alt=""></a></li>
              <li class="list-inline-item"><a href="#"><img src="assets/images/pay3.png" alt=""></a></li>
            </ul>
          </div>
          <form method="POST" action="">
            <button type="submit" name="proceed_checkout" class="btn btn-dark rounded-pill py-2 btn-block">Proceed to checkout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php

if(isset($_POST['proceed_checkout'])){
  foreach($cartList as $cart){
    $product = Sanpham::getOneById($pdo, $cart['idSPcart']);
    $tongtien = $product['dongia1'] * $cart['quantity'];
    $order->insert($pdo, $cart['idCart'], $infoUser['id'],$cart['idSPcart'],$cart['ring_size'], $product['dongia1'],$cart['quantity'], $tongtien, 0);
  }
  $cartRepository->deleteByidUser($pdo, $infoUser['id']);
  echo "<script>alert('Đặt hàng thành công');
    window.location.href='index.php';
    </script>";
}
?>

<?php require_once "includes/footer.php"; ?>
