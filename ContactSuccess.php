<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/phpmailer/src/SMTP.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy và làm sạch dữ liệu từ form
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if ($email) {
        // Tạo một instance PHPMailer mới
        $mail = new PHPMailer(true);

        try {
            // Cấu hình máy chủ
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   // Kích hoạt đầu ra gỡ lỗi chi tiết
            $mail->isSMTP();                                         // Gửi bằng SMTP
            $mail->Host = 'smtp.gmail.com';                        // Thiết lập máy chủ SMTP để gửi
            $mail->SMTPAuth = true;                                  // Kích hoạt xác thực SMTP
            $mail->Username = 'ivshop29@gmail.com';                  // Tên đăng nhập SMTP
            $mail->Password = 'jvqvrponmshaswbg';                    // Mật khẩu SMTP
            $mail->SMTPSecure = 'ssl';         // Kích hoạt mã hóa TLS ngầm định
            $mail->Port = 465;                                       // Cổng TCP để kết nối

            // Người nhận
            $mail->setFrom($email, $name);
            $mail->addAddress('ivshop29@gmail.com','ivShop');                 // Thêm người nhận
            $mail->addReplyTo($email, $name);

            // Nội dung email
            $mail->isHTML(true);                                     // Đặt định dạng email là HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message);                   // Nội dung văn bản thuần cho các khách hàng email không hỗ trợ HTML

            // Gửi email
            $mail->send();
            // echo 'Tin nhắn đã được gửi! Cảm ơn bạn đã dành thời gian!!';
            echo "<script>alert('Tin nhắn đã được gửi! Cảm ơn bạn đã dành thời gian!!');
            window.location.href='index.php';</script>";
        } catch (Exception $e) {
            echo "Không thể gửi tin nhắn. Lỗi Mailer: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Địa chỉ email không hợp lệ';
    }
} else {
    echo 'Phương thức yêu cầu không hợp lệ';
}
?>
