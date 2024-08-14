<?php 
    require_once "../class/Auth.php";
    require_once "../class/Database.php";
    require_once "../class/Sanpham.php";
    require_once "../class/Orders.php";

    $db = new Database();
    $pdo = $db->getConnect();

    $countUser = Auth::countAllUser($pdo);
    $countProduct = Sanpham::countAll($pdo);
    $countOders = Orders::countAllOders($pdo);
    $totalRevenue = Orders::getTotalRevenue($pdo);
    // var_dump($countOders);
?>
<?php require_once "../admin/includesAdmin/headerAdmin.php" ?>
<div class="container mt-4">
        <h1 class="text-center mb-4">Admin Dashboard</h1>
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title mb-2"> Danh sách người dùng</h5>
                            <p><?= $countUser ?></p>
                        </div>
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title mb-2">Danh sách sản phẩm</h5>
                            <p><?= $countProduct ?></p>
                        </div>
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-white bg-danger shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title mb-2">Danh sách đơn hàng</h5>
                            <p><?= $countOders; ?></p>
                        </div>
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-white bg-warning shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title mb-2">Tổng doanh thu</h5>
                            <p><?= number_format($totalRevenue, 0, ",", ".") ?> VNĐ</p>
                        </div>
                        <i class="fa fa-btc fa-2x"></i>
                    </div>
                </div>
            </div> 
           
        </div>

    </div>

<?php require_once "../admin/includesAdmin/footerAdmin.php" ?>