<?php
    require_once("Auth.php");
    require_once ("Database.php");

    $db = new Database();
    $pdo = $db->getConnect();
    $checkCookie = Auth::loginWithCookie($pdo);
    if($checkCookie != null){
        echo '<ul class="navbar-nav ">
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-check"></i> '.$checkCookie['fullname'].'
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="../class/logoutCookie.php">Đăng xuất <i class="bi bi-box-arrow-right"></i></a></li>
            </ul>
        </li>
          </ul>';
    }

?>