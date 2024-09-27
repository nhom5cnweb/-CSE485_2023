<?php 
include("services/LoginService.php"); // Bao gồm tệp LoginService chứa logic đăng nhập

class LoginController {
    public function index() {
        include("views/login_form.php"); // Gọi view để hiển thị form đăng nhập
    } 

    public function login() {
        // Nhận tên người dùng và mật khẩu từ biểu mẫu đăng nhập
        $userName = $_POST['username'] ?? ''; // Nếu không có giá trị, gán '' cho biến
        $pw = $_POST['password'] ?? ''; // Tương tự như trên
        
        // Tạo một đối tượng của LoginService để truy cập các phương thức liên quan đến đăng nhập
        $userObj = new LoginService();
        // Gọi phương thức getUser để tìm người dùng trong cơ sở dữ liệu
        $getUser = $userObj->getUser($userName);

    }
}
?>