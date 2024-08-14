<?php 
require_once "../class/Database.php";
require_once "../class/Orders.php";
require_once "../class/Sanpham.php";
require_once "../class/Auth.php";

$db = new Database();
$pdo = $db->getConnect();
$orders = Orders::getAllOrders($pdo);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_order'])) {
        $orderId = $_POST['order_id'];
        $order = Orders::getOrderById($pdo, $orderId);
        
        if ($order['trangthai'] == 0) {
            Orders::deleteById($pdo, $orderId);
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        }
    } elseif (isset($_POST['approve_order'])) {
        $orderId = $_POST['order_id'];
        $order = Orders::getOrderById($pdo, $orderId);
        $product = Sanpham::getOneById($pdo, $order['id_sanpham']);

        if ($product['soluongsp'] >= $order['soluongsanpham']) {
            Orders::approveById($pdo, $orderId);
            
            // Trừ số lượng sản phẩm khi duyệt đơn
            Sanpham::decreaseQuantity($pdo, $order['id_sanpham'], $order['soluongsanpham']);
            
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "<script>alert('Đơn hàng không thể duyệt vì số lượng hàng trong kho không đủ cung c!!!');
            window.location.href='../admin/ordersAdmin.php';</script>";
        }
    }
}

require_once "../admin/includesAdmin/headerAdmin.php";
?>
<div class="container-md mt-5">
    <h1 class="text-center font-weight-bold mb-5">Manage Orders</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Cart ID</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Size</th>
                    <th scope="col">Product Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                    <th scope="col">Approve</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($orders as $order): 
                $product = Sanpham::getOneById($pdo, $order['id_sanpham']);
                $user = Auth::getById($pdo, $order['id_nguoidung']);
            ?>
            <form method="POST">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                <tr>
                    <td><?= $order['id']; ?></td>
                    <td><?= $order['id_giohang']; ?></td>
                    <td><?= $user['fullname']; ?></td>
                    <td><?= $product['tensp']; ?></td>
                    <td><?= $order['size_sanpham']; ?></td>
                    <td><?= number_format($order['dongiasanpham'], 0, ",", ".") ?></td>
                    <td><?= $order['soluongsanpham']; ?></td>
                    <td><?= number_format($order['tongtien'], 0, ",", ".") ?></td>
                    <td>
                    <?php 
                        if($order['trangthai'] == 0){
                            echo '<span>Chờ duyệt</span>';
                        }else{
                            echo '<span>Đã duyệt</span>';
                        }
                    ?> 
                    </td>
                    <td><?= $order['date']; ?></td>
                    <td>
                        <?php if ($order['trangthai'] == 0): ?>
                            <button type="submit" name="approve_order" class="btn btn-outline-success">Duyệt đơn</button>
                        <?php else: ?>
                            <button type="button" class="btn btn-outline-secondary" disabled>Đã duyệt</button>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($order['trangthai'] == 0): ?>
                            <button type="submit" name="remove_order" class="btn btn-outline-dark">Hủy đơn</button>
                        <?php else: ?>
                            <button type="button" class="btn btn-outline-secondary" disabled>Hủy đơn</button>
                        <?php endif; ?>
                    </td>
                </tr>
            </form>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once "../admin/includesAdmin/footerAdmin.php"; ?>
