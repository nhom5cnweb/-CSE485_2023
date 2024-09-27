<?php
include("services/AuthorService.php");
class AuthorController{
    // Hàm xử lý hành động index
    public function index(){
        // Nhiệm vụ 1: Tương tác với Services/Models
        $authorService = new AuthorService();
        $authors = $authorService->getAllAuthors();
        // Nhiệm vụ 2: Tương tác với View
        include("views/author/index.php");
    }

    public function add() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $authorName = $_POST['txtAuName'];

            // Xử lý thêm thể loại
            $authorService = new AuthorService();
            if ($authorService->getAddAuthor($authorName)) {
                header("Location: view/author/index.php?msg=Thêm tác giả thành công!");
                exit();
            } else {
                $errorMsg = "Lỗi: Không thể thêm thể loại.";
            }
        }
        // Hiển thị view thêm thể loại
        include("views/author/add_author.php");
    }
    

    public function edit() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $authorId = $_POST['txtAuId'];
            $authorName = $_POST['txtAutName'];
    
            // Xử lý cập nhật thể loại
            $authorService = new AuthorService();
            if ($authorService->updateAuthor($authorId, $authorName)) {
                header("Location: index.php?controller=author&action=index&id=$authorId&msg=Cập nhật tác giả thành công!");
                exit();
            } else {
                $errorMsg = "Lỗi: Không thể cập nhật tác giả.";
            }
        } else {
            // Lấy thông tin thể loại theo ID (để hiển thị trong form)
            $id = $_GET['id']; // Lấy ID từ query string
            $authorService = new AuthorService();
            $author = $authorService->getAuthorById($id);
            
            // Kiểm tra nếu thể loại không tồn tại
            if (!$author) {
                header("Location: index.php?controller=author&action=index&msg=Tác giả không tồn tại!");
                exit();
            }
        }
    
        // Hiển thị view sửa thể loại
        include("views/author/edit_author.php");
    }
    public function del() {
        if (isset($_GET['id'])) {
            $au_id = $_GET['id'];
    
            $authorService = new AuthorService();
            if ($authorService->deleteAuthor($au_id)) {
                header("Location: index.php?controller=author&action=index&msg=Xóa tác giả thành công!");
                exit();
            } else {
                $errorMsg = "Lỗi: Không thể xóa tác giả.";
            }
        } else {
            header("Location: index.php?controller=author&action=index&msg=Tác giả không tồn tại!");
            exit();
        }
    }
}