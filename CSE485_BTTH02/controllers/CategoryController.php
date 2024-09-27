<?php
include("services/CategoryService.php");
class CategoryController{
    // Hàm xử lý hành động index
    public function index(){
        // Nhiệm vụ 1: Tương tác với Services/Models
        $categoryService = new CategoryService();
        $categorys = $categoryService->getAllCategorys();
        // Nhiệm vụ 2: Tương tác với View
        include("views/category/index.php");
    }

    public function add() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $categoryName = $_POST['txtCatName'];

            // Xử lý thêm thể loại
            $categoryService = new CategoryService();
            if ($categoryService->getAddCategory($categoryName)) {
                header("Location: view/category/index.php?msg=Thêm thể loại thành công!");
                exit();
            } else {
                $errorMsg = "Lỗi: Không thể thêm thể loại.";
            }
        }
        // Hiển thị view thêm thể loại
        include("views/category/add_category.php");
    }
    

    public function edit() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $categoryId = $_POST['txtCatId'];
            $categoryName = $_POST['txtCatName'];
    
            // Xử lý cập nhật thể loại
            $categoryService = new CategoryService();
            if ($categoryService->updateCategory($categoryId, $categoryName)) {
                header("Location: index.php?controller=category&action=index&id=$categoryId&msg=Cập nhật thể loại thành công!");
                exit();
            } else {
                $errorMsg = "Lỗi: Không thể cập nhật thể loại.";
            }
        } else {
            // Lấy thông tin thể loại theo ID (để hiển thị trong form)
            $id = $_GET['id']; // Lấy ID từ query string
            $categoryService = new CategoryService();
            $category = $categoryService->getCategoryById($id);
            
            // Kiểm tra nếu thể loại không tồn tại
            if (!$category) {
                header("Location: index.php?controller=category&action=index&msg=Thể loại không tồn tại!");
                exit();
            }
        }
    
        // Hiển thị view sửa thể loại
        include("views/category/edit_category.php");
    }
    public function del() {
        if (isset($_GET['id'])) {
            $cat_id = $_GET['id'];
    
            $categoryService = new CategoryService();
            if ($categoryService->deleteCategory($cat_id)) {
                header("Location: index.php?controller=category&action=index&msg=Xóa thể loại thành công!");
                exit();
            } else {
                $errorMsg = "Lỗi: Không thể xóa thể loại.";
            }
        } else {
            header("Location: index.php?controller=category&action=index&msg=Thể loại không tồn tại!");
            exit();
        }
    }
}