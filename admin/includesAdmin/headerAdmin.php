<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin iVShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-lY6+8CO+rXmKpzpfC3Ll9g6ZzLbwo8NTbPD1eYDJENhJlIiK/2h5K87P8LwWpMJp" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-expand-md navbar-light bg-white border border-gray-200 dark:bg-gray-900">
  <div class="container-fluid">
    <a href="#" class="navbar-brand d-flex align-items-center">
      <h3>iV<span style="color:red">Shop</span></h3>  
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse px-xl-5 p-1" id="navbarNav">
      <ul class="navbar-nav ms-auto px-xl-5">
        <li class="nav-item">
          <a class="nav-link active" href="indexAdmin.php"><i class="fas fa-home me-1"></i>Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="productAdmin.php"><i class="fas fa-tasks me-1"></i>Quản lý sản phẩm</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="userAdmin.php"><i class="fas fa-users-cog me-1"></i>Quản lý người dùng</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ordersAdmin.php"><i class="fas fa-shipping-fast me-1"></i>Quản lý đơn hàng</a>
        </li>
        <li class="nav-item">
          <?php
              require_once "../class/filterWithCookieAdmin.php";
          ?>
        </li>
      </ul>
    </div>
  </div>
</nav>


