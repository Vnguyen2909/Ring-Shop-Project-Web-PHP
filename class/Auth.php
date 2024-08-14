<?php
class Auth{
    public static function checkExist($pdo, $field, $value) {
        // Sanitize the field name to prevent SQL injection
        $validFields = ['username', 'email', 'phone'];
        if (!in_array($field, $validFields)) {
            throw new InvalidArgumentException("Invalid field name");
        }

        $sql = "SELECT COUNT(*) FROM user WHERE $field = :value";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public static function register($pdo, $username, $password, $fullname, $address, $email, $phone, $imageUser) {
        try {
            // Check for the existence of username, email, and phone
            if (self::checkExist($pdo, "username", $username)) {
                echo '<script>alert("Username đã tồn tại.")</script>';
                return false;
            }
            if (self::checkExist($pdo, "email", $email)) {
                echo '<script>alert("Email đã tồn tại.")</script>';
                return false;
            }
            if (self::checkExist($pdo, "phone", $phone)) {
                echo '<script>alert("Phone đã tồn tại.")</script>';
                return false;
            }

            // Handle user image
            $target_file = null;
            if (!empty($_FILES["imageUser"]["name"])) {
                $target_dir = "assets/images/imgUser/";
                $target_file = $target_dir . basename($_FILES["imageUser"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if file is an image
                $check = getimagesize($_FILES["imageUser"]["tmp_name"]);
                if ($check !== false) {
                    if ($_FILES["imageUser"]["size"] > 10000000) {
                        echo '<script>alert("Xin lỗi, file của bạn quá lớn.")</script>';
                        return false;
                    }

                    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                        echo '<script>alert("Xin lỗi, chỉ cho phép các file JPG, JPEG, PNG & GIF.")</script>';
                        return false;
                    }

                    // Sanitize file name
                    $safeFileName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES["imageUser"]["name"]));
                    $target_file = $target_dir . $safeFileName;

                    if (!move_uploaded_file($_FILES["imageUser"]["tmp_name"], $target_file)) {
                        echo '<script>alert("Xin lỗi, đã xảy ra lỗi khi tải lên file của bạn.")</script>';
                        return false;
                    }
                } else {
                    echo '<script>alert("File không phải là ảnh.")</script>';
                    return false;
                }
            }

            // Insert user information into the database
            $sql = "INSERT INTO user (username, password, fullname, address, email, phone, role, imageUser) 
                    VALUES (:username, :password, :fullname, :address, :email, :phone, 1, :imageUser)";
            $stmt = $pdo->prepare($sql);

            // Bind the values to the query to avoid SQL injection
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR); // Store password as plain text
            $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':imageUser', $target_file, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo '<script>alert("Đăng ký thành công!"); window.location.href="login.php";</script>';
                return true;
            } else {
                echo '<script>alert("Đăng ký không thành công. Vui lòng thử lại.")</script>';
                return false;
            }
        } catch (PDOException $e) {
            error_log("PDO Error: " . $e->getMessage());
            echo '<script>alert("Lỗi trong quá trình đăng ký. Vui lòng thử lại.")</script>';
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            echo '<script>alert("Lỗi trong quá trình đăng ký. Vui lòng thử lại.")</script>';
            return false;
        }
    }
    
    
    public static function login($pdo,$username,$password){
        $run = Auth::findOneByUsernameAndPassword($pdo,$username,$password);
        if($run){
            setcookie("username",$run['username'],time()+1314000,"/");
            setcookie("password",$run['password'],time()+1314000,"/");
            return true;
        }
        return false;
    }

    public static function findOneByUsernameAndPassword($pdo,$username,$password){
        $sql="SELECT * FROM user WHERE username = '$username' and password = '$password'";
        $stmt = $pdo->prepare($sql);
        if($stmt->execute()){
           return $stmt->fetch($stmt->setFetchMode(PDO::FETCH_ASSOC));
        }
    }

    public static function loginWithCookie($pdo){
        if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {	
            $username= $_COOKIE['username'];
            $password= $_COOKIE['password'];
            // Kiểm tra nếu username và password không rỗng
            if(!empty($username) && !empty($password)) {
                $run = Auth::findOneByUsernameAndPassword($pdo, $username, $password);
                return $run ? $run : null;
            }
        }
        return null;
  }
  public static function updateinforUser($pdo, $fullname, $address, $email, $phone, $idUser, $imageUser){
    $sql = "UPDATE user SET fullname = :fullname, address = :address, email = :email, phone = :phone, imageUser = :imageUser WHERE id = :idUser";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':idUser', $idUser);
    $stmt->bindParam(':imageUser', $imageUser);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        // Log the error or throw a custom exception
        throw new Exception('Error updating user information: ' . $e->getMessage());
    }
}


public static function countAllUser($pdo) {
    try {
        $sql = "SELECT COUNT(*) FROM user";
        $stmt = $pdo->query($sql);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}


public static function AllUser($pdo){
    $sql = "SELECT * FROM user";
    $stmt = $pdo->prepare($sql);
    if($stmt->execute()){
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return [];
}

public static function removeUser($pdo, $userId){
    $sql = "DELETE FROM user WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    return $stmt->execute();
}
public static function getById($pdo,$id){
    $sql = "SELECT * from user where id=:id"; 
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id",$id);

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
?>