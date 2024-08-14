<?php 
require_once "class/Database.php";
require_once "class/Orders.php";
require_once "class/Product.php";
require_once "class/Auth.php";

$db = new Database();
$pdo = $db->getConnect();

$infoUser = Auth::loginWithCookie($pdo);
$ordersUser = Orders::getOrdersByUserId($pdo, $infoUser['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_order'])) {
    $orderId = $_POST['order_id'];
    $order = Orders::getOrderById($pdo, $orderId);
    
    if ($order['trangthai'] == 0) {
        Orders::deleteById($pdo, $orderId);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<?php require_once "includes/header.php"; ?>
<section class="h-custom" style="padding-bottom: 0; min-height: 500px">
    <div class="container py-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Mã đơn hàng</th>
                                <th style="text-align: center;">Tên sản phẩm</th>
                                <th style="text-align: center;">Giá</th>
                                <th style="text-align: center;">Số lượng</th>
                                <th style="text-align: center;">Tổng</th>
                                <th style="text-align: center;">Trạng thái</th>
                                <th style="text-align: center;">Ngày đặt</th>
                                <th style="text-align: center;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ordersUser as $order) : 
                                $product = Sanpham::getOneById($pdo, $order['id_sanpham']);

                            ?>
                                <tr>
                                    <td style="text-align: center;"><?= $order['id']; ?></td>
                                    <td><?= $product['tensp']; ?></td>
                                    <td><?= number_format($order['dongiasanpham'], 0) . ' VNĐ'; ?></td>
                                    <td style="text-align: center;"><?= $order['soluongsanpham']; ?></td>
                                    <td><?= number_format($order['tongtien'], 0) . ' VNĐ'; ?></td>
                                    <td style="text-align: center;"><?= $order['trangthai'] == 0 ? 'Đang chờ' : 'Đã duyệt'; ?></td>
                                    <td><?= $order['date']; ?></td>
                                    <td style="text-align: center;">
                                        <?php if ($order['trangthai'] == 0) : ?>
                                            <form method="POST">
                                                <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                                <button type="submit" name="remove_order" class="btn btn-outline-dark">Hủy đơn hàng</button>
                                            </form>
                                        <?php else : ?>
                                            <span>Đơn hàng của bạn đang giao</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once "includes/footer.php"; ?>
