<?php
include("configs/DBConnection.php");
include("models/Author.php");
class AuthorService{
    public function getAllAuthors(){
        // 4 bước thực hiện
       $dbConn = new DBConnection();
       $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "SELECT * FROM tacgia ";
        $stmt = $conn->query($sql);

        // B3. Xử lý kết quả
        $authors = [];
        while($row = $stmt->fetch()){
            $author = new Author($row['ma_tgia'],$row['ten_tgia']);
            array_push($authors,$author);
        }
        // Mảng (danh sách) các đối tượng Article Model

        return $authors;
    }
    public function getAddAuthor($name) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        
        $sql = "INSERT INTO tacgia (ten_tgia) VALUES (:name)";
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
    public function getAuthorById($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        
        $sql = "SELECT * FROM tacgia WHERE ma_tgia = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch();
        if ($row) {
            return new Author($row['ma_tgia'], $row['ten_tgia']);
        }
        return null; // Return null if no category is found
    }
    public function updateAuthor($id, $name) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        
        $sql = "UPDATE tacgia SET ten_tgia = :name WHERE ma_tgia = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        
        return $stmt->execute(); // Trả về true nếu cập nhật thành công
    }
    public function deleteAuthor($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
    
        $sql = "DELETE FROM tacgia WHERE ma_tgia = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
    
        return $stmt->execute(); // Trả về true nếu xóa thành công
    }
    
}

// Bắt đầu xử lý yêu cầu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['id'])) {
        // Tình huống cập nhật thể loại
        $authorName = $_POST['txtAuName'] ?? null; // Tên thể loại mới
        $authorId = $_GET['id']; // ID thể loại cần sửa

        if ($authorName) {
            // Khởi tạo dịch vụ và cập nhật thể loại
            $authorService = new AuthorService();
            if ($authorService->updateAuthor($authorId, $authorName)) {
                header("Location: index.php?controller=author&action=index");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Lỗi: Không thể cập nhật tác giả.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Lỗi: Tên tác giả không được để trống.</div>";
        }
    } else {
        // Tình huống thêm thể loại
        $authorName = $_POST['txtAuName'] ?? null; // Lấy tên thể loại từ biểu mẫu

        if ($authorName) {
            // Khởi tạo dịch vụ và thêm thể loại
            $authorService = new AuthorService();
            if ($authorService->getAddAuthor($authorName)) {
                header("Location: index.php?controller=author&action=index");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Lỗi: Không thể thêm tác giả.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Lỗi: Tên giả không được để trống.</div>";
        }
    }
}   