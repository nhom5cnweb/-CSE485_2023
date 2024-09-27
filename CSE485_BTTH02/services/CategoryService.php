<?php
include("configs/DBConnection.php");
include("models/Category.php");
class CategoryService{
    public function getAllCategorys(){
        // 4 bước thực hiện
       $dbConn = new DBConnection();
       $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "SELECT * FROM theloai ";
        $stmt = $conn->query($sql);

        // B3. Xử lý kết quả
        $categorys = [];
        while($row = $stmt->fetch()){
            $category = new Category($row['ma_tloai'],$row['ten_tloai']);
            array_push($categorys,$category);
        }
        // Mảng (danh sách) các đối tượng Article Model

        return $categorys;
    }
    public function getAddCategory($name) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        
        $sql = "INSERT INTO theloai (ten_tloai) VALUES (:name)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        
        if ($stmt->execute()) {
            return true;
        } else {
            // Ghi log hoặc xử lý lỗi nếu không có thể thêm
            error_log("Failed to add category: " . implode(", ", $stmt->errorInfo()));
            return false; // Trả về false nếu không thành công
        }
    }
    public function getCategoryById($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        
        $sql = "SELECT * FROM theloai WHERE ma_tloai = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch();
        if ($row) {
            return new Category($row['ma_tloai'], $row['ten_tloai']);
        }
        return null; // Return null if no category is found
    }
    public function updateCategory($id, $name) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        
        $sql = "UPDATE theloai SET ten_tloai = :name WHERE ma_tloai = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        
        return $stmt->execute(); // Trả về true nếu cập nhật thành công
    }
    public function deleteCategory($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
    
        $sql = "DELETE FROM theloai WHERE ma_tloai = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
    
        return $stmt->execute(); // Trả về true nếu xóa thành công
    }
    
}

// Bắt đầu xử lý yêu cầu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['id'])) {
        // Tình huống cập nhật thể loại
        $categoryName = $_POST['txtCatName'] ?? null; // Tên thể loại mới
        $categoryId = $_GET['id']; // ID thể loại cần sửa

        if ($categoryName) {
            // Khởi tạo dịch vụ và cập nhật thể loại
            $categoryService = new CategoryService();
            if ($categoryService->updateCategory($categoryId, $categoryName)) {
                header("Location: index.php?controller=category&action=index");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Lỗi: Không thể cập nhật thể loại.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Lỗi: Tên thể loại không được để trống.</div>";
        }
    } else {
        // Tình huống thêm thể loại
        $categoryName = $_POST['txtCatName'] ?? null; // Lấy tên thể loại từ biểu mẫu

        if ($categoryName) {
            // Khởi tạo dịch vụ và thêm thể loại
            $categoryService = new CategoryService();
            if ($categoryService->getAddCategory($categoryName)) {
                header("Location: index.php?controller=category&action=index");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Lỗi: Không thể thêm thể loại.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Lỗi: Tên thể loại không được để trống.</div>";
        }
    }
}   