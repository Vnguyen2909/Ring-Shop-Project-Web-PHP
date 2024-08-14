<?php 
    require "class/Database.php";
    require "class/Auth.php";

    $db = new Database();
    $pdo = $db->getConnect();
    if(isset($_POST['submit'])){
        $role = Auth::login($pdo,$_POST['username'],$_POST['password']);
    }
?>
<?php 
  require_once "includes/header.php";
?>
<section class="text-center text-lg-start">
        <style>
            body {
                background-color: #eee;
            }
            
            .cascading-right {
                margin-right: -50px;
            }
            
            @media (max-width: 991.98px) {
                .cascading-right {
                    margin-right: 0;
                }
            }
        </style>
        <div class="container py-4">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="card cascading-right" style=" background: hsla(0, 0%, 100%, 0.55); backdrop-filter: blur(30px); ">
                        <div class="card-body p-5 shadow-5 text-left">
                            <h2 class="fw-bold mb-5"> LOG IN</h2>
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                <!-- 2 column grid layout with text inputs for the first and last names -->

                                <div class="form-outline mb-3">
                                    <i class="bi bi-person"></i>
                                    <label class="form-label" for="name">Username</label>
                                    <input minlength="5" maxlength="20" name="username" id="username" type="text" class="form-control" placeholder="Username" required>
                                </div>

                                <!-- Password input -->
                                <div class="form-outline mb-3">
                                    <i class="bi bi-key"></i>
                                    <label class="form-label" for="pass">Password</label>
                                    <input minlength="8" maxlength="50" name="password" id="password" type="password" class="form-control" placeholder="Password" required>
                                </div>

                            
                                <div class="form-check d-flex justify-content-left mb-4">
                                    <input class="form-check-input me-2" type="checkbox" id="showPassword" onclick="togglePassword()">
                                    <label class="form-check-label" for="showPassword">
                                        Hiện mật khẩu
                                    </label>
                                </div>

                                <!-- Submit button -->
                                <div class="form-group">
		            	            <button name="submit" type="submit" class="form-control btn btn-dark submit px-3">Sign In</button>
		                        </div>
                                <div class="text-wrap py-2 text-center d-flex align-items-center order-md-last">
							        <div class="text w-100">
								        <p>Don't have an account? <a href="register.php">Sign Up</a></p>     
							        </div>
			                    </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="https://images.pexels.com/photos/1521306/pexels-photo-1521306.jpeg?cs=srgb&dl=pexels-kirsten-b%C3%BChne-1521306.jpg&fm=jpg" class="w-100 rounded-5 shadow-4" alt="" />
                </div>
            </div>
        </div>
        <!-- Jumbotron -->
    </section>

<script>
    function togglePassword() {
        var passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
</script>

<?php 
    if(isset($_POST['submit'])){
            $role = Auth::login($pdo,$_POST['username'],$_POST['password']);
            if($role)
            {
                echo "<script>alert('Đăng nhập thành công');
                window.location.href='index.php';</script>";
                
            }else
            {
                echo "<script>alert('Tài khoản hoặc mật khẩu không chính xác');
                window.location.href='login.php';</script>";
            }
        }
?>
<?php 
  require_once "includes/footer.php";
?>
