<?php 
include("configs/DBConnection.php"); // Bao gồm tệp kết nối cơ sở dữ liệu
include("models/Login.php"); // Bao gồm tệp mô hình người dùng (Login)

class LoginService {
    // Phương thức để lấy thông tin người dùng dựa trên tên đăng nhập
    public function getUser($username) {
        $dbConn = new DBConnection(); // Tạo một đối tượng DBConnection
        $conn = $dbConn->getConnection(); // Lấy kết nối đến cơ sở dữ liệu
        
        // SQL để lấy thông tin người dùng
        $sql = "SELECT * FROM tai_khoan WHERE ten_dang_nhap = :username";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Lấy dữ liệu người dùng
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user ?: null; // Nếu không tìm thấy, trả về null
    }

    // Phương thức để xác minh thông tin đăng nhập
    public function login($username, $password) {
        session_start(); // Bắt đầu phiên

        // Lấy thông tin người dùng
        $user = $this->getUser(trim($username));
        
        // Kiểm tra xem có người dùng và xác minh mật khẩu
        if ($user && password_verify(trim($password), $user['mat_khau'])) {
            // Đăng nhập thành công, lưu vào session
            $_SESSION['user_id'] = $user['id']; // Lưu ID người dùng
            $_SESSION['username'] = $username;
            $_SESSION['success_message'] = 'Đăng nhập thành công.';
            // Chuyển hướng đến trang admin
            header("Location: index.php?controller=homepage&action=showHomepage");
            exit();
        } else {
            // Tạo thông báo lỗi nếu tên đăng nhập hoặc mật khẩu không đúng
            return 'Tài khoản hoặc mật khẩu không đúng.';
        }
    }


    // Phương thức để xác minh mật khẩu
    
}
?>