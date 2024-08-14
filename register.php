<?php 
require_once "class/Database.php";
require_once "class/Auth.php";
require_once "class/checkEmpty.php";

$pdo = Database::getConnect();
?>

<?php 
require_once "includes/header.php";
?>

<section class="vh-10" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px; margin: 30px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Register</p>

                                <form class="mx-1 mx-md-4" method="POST" enctype="multipart/form-data">
                                    <div class="d-flex flex-row align-items-center mb-3">
                                        <div class="form-outline flex-fill mb-0">
                                            <i class="bi bi-person"></i>
                                            <label class="form-label" for="username">Username</label>
                                            <input minlength="5" maxlength="20" type="text" name="username" id="username" required class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-3">
                                        <div class="form-outline flex-fill mb-0">
                                            <i class="bi bi-key"></i>
                                            <label class="form-label" for="password">Password</label>
                                            <input minlength="8" maxlength="50" type="password" name="password" id="password" required class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-3">
                                        <div class="form-outline flex-fill mb-0">
                                            <i class="bi bi-key"></i>
                                            <label class="form-label" for="confirmpassword">Confirm Password</label>
                                            <input minlength="8" maxlength="50" type="password" name="confirmpassword" id="confirmpassword" required class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-3">
                                        <div class="form-outline flex-fill mb-0">
                                            <i class="bi bi-person"></i>
                                            <label class="form-label" for="fullname">Full name</label>
                                            <input minlength="10" maxlength="50" type="text" name="fullname" id="fullname" required class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-3">
                                        <div class="form-outline flex-fill mb-0">
                                            <i class="bi bi-envelope"></i>
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" name="email" id="email" required class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-3">
                                        <div class="form-outline flex-fill mb-0">
                                            <i class="bi bi-house"></i>
                                            <label class="form-label" for="address">Address</label>
                                            <input type="text" name="address" id="address" required class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-3">
                                        <div class="form-outline flex-fill mb-0">
                                            <i class="bi bi-telephone"></i>
                                            <label class="form-label" for="phone">Phone</label>
                                            <input type="text" name="phone" id="phone" required class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-3">
                                        <div class="form-outline flex-fill mb-0">
                                            <i class="bi bi-telephone"></i>
                                            <label class="form-label" for="imageUser">Image User</label>
                                            <input class="form-control" type="file" name="imageUser" id="imageUser">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button name="submit" type="submit" class="form-control btn btn-dark submit px-3">Register</button>
                                    </div>

                                    <div class="text-wrap py-2 text-center d-flex align-items-center order-md-last">
                                        <div class="text w-100">
                                            <p>You have an account? <a href="login.php">Sign In</a></p> 
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-5 d-flex align-items-center order-1 order-lg-2">
                                <img src="https://images.unsplash.com/photo-1533738363-b7f9aef128ce?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=735&q=80" class="w-100 rounded-5 shadow-4" alt="Sample image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
if (isset($_POST['submit'])) {
    if (CheckEmpty::checkEmpty(['username', 'password', 'confirmpassword', 'fullname', 'address', 'email', 'phone'])) {
        if ($_POST['password'] !== $_POST['confirmpassword']) {
            echo "<script>alert('Mật khẩu và xác nhận mật khẩu không khớp. Vui lòng thử lại.');</script>";
        } else {
            Auth::register($pdo, $_POST['username'], $_POST['password'], $_POST['fullname'], $_POST['address'], $_POST['email'], $_POST['phone'], $_FILES['imageUser']);
        }
    }
}
?>

<?php 
require_once "includes/footer.php";
?>
