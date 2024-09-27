<?php
include("services/ArticleService.php");

class ArticleController {
    // Hàm xử lý hành động index
    public function index() {
        $articleService = new ArticleService();
        $articles = $articleService->getAllArticles();
        include("views/article/index.php");
    }

    public function add() {
        $articleService = new ArticleService();
        $categories = $articleService->getAllCategories();
        $authors = $articleService->getAllAuthors();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['txtTitle'];
            $nameSong = $_POST['txtNameSong'];
            $category_id = $_POST['category_id'];
            $content = $_POST['txtContent'];

            // Gọi phương thức để thêm bài viết
            $result = $articleService->getAddArticle($title, $nameSong, $category_id, $content);

            if ($result) {
                header("Location: index.php?controller=article&action=index&success=1");
                exit();
            }
        }

        // Hiển thị view thêm bài viết với danh sách thể loại và tác giả
        include("views/article/add_article.php");
    }

    public function edit() {
        $articleService = new ArticleService();
        $categories = $articleService->getAllCategories();
        $authors = $articleService->getAllAuthors();

        // Lấy thông tin bài viết theo ID
        $id = $_GET['id'] ?? null;
        if ($id) {
            $article = $articleService->getArticleById($id);

            if (!$article) {
                header("Location: index.php?controller=article&action=index&msg=Bài viết không tồn tại!");
                exit();
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['txtTitle'];
            $nameSong = $_POST['txtNameSong'];
            $category_id = $_POST['category_id'];
            $content = $_POST['txtContent'];

            // Gọi phương thức để cập nhật bài viết
            $result = $articleService->updateArticle($id, $title, $nameSong, $category_id, $content);

            if ($result) {
                header("Location: index.php?controller=article&action=index&success=1");
                exit();
            }
        }

        // Hiển thị view sửa bài viết với danh sách thể loại và tác giả
        include("views/article/edit_article.php");
    }

    public function del() {
        if (isset($_GET['id'])) {
            $articleId = $_GET['id'];
            $articleService = new ArticleService();

            if ($articleService->deleteArticle($articleId)) {
                header("Location: index.php?controller=article&action=index&msg=Xóa bài viết thành công!");
                exit();
            } else {
                $errorMsg = "Lỗi: Không thể xóa bài viết.";
            }
        } else {
            header("Location: index.php?controller=article&action=index&msg=Bài viết không tồn tại!");
            exit();
        }
    }
}