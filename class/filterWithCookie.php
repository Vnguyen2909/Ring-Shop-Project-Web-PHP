<?php
    require_once "Auth.php";
    require_once "Database.php";

    $pdo = Database::getConnect();
    
    $checkCookie = Auth::loginWithCookie($pdo);
    // var_dump($checkCookie = Auth::loginWithCookie($pdo));
    if($checkCookie !== null){
        if($checkCookie['role']==0){
            // echo '<script>alert("Chào mừng đến với trang ADMIN!"); 
            //         window.location.href="admin/homeAdmin.php";</script>';
            echo '<ul class="navbar-nav ">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-check"></i> '.$checkCookie['fullname'].'
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person-lines-fill"></i> Thông tin cá nhân</a></li>
                  <li><a class="dropdown-item" href="cart.php"><i class="bi bi-cart"></i> Giỏ hàng</a></li>
                  <li><a class="dropdown-item" href="admin/indexAdmin.php"><i class="bi bi-cart"></i> Admin</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="class/logoutCookie.php">Đăng xuất <i class="bi bi-box-arrow-right"></i></a></li>
                </ul>
            </li>
              </ul>';
        }else
        {
            // echo '<a href="#" style="margin: 5px"> Wellcome: '.$checkCookie['username'].'!</a>
            //       <a href="class/logoutCookie.php" style="margin: 5px">Đăng xuất <i class="bi bi-box-arrow-right"></i></a>
            //       <a href="#" style="font-size: 1.5rem;margin:0px 10px"><i class="bi bi-cart"></i></a>';
            echo '<ul class="navbar-nav ">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-check"></i> '.$checkCookie['fullname'].'
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person-lines-fill"></i> Thông tin cá nhân</a></li>
                  <li><a class="dropdown-item" href="cart.php"><i class="bi bi-cart"></i> Giỏ hàng</a></li>
                  <li><a class="dropdown-item" href="Ordersuser.php"><i class="bi bi-box2"></i> Đơn hàng</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="class/logoutCookie.php">Đăng xuất <i class="bi bi-box-arrow-right"></i></a></li>
                </ul>
            </li>
              </ul>';
        }
    }else{
        echo '<a class="btn-account" href="login.php"><i class="bi bi-person-circle"></i></a>';
    }
?>