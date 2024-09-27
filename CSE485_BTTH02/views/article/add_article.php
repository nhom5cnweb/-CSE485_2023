<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Bài Viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-light shadow p-3 mb-5 rounded">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Quản trị</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="./">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="../index.php">Trang ngoài</a></li>
                        <li class="nav-item"><a class="nav-link" href="category.php">Thể loại</a></li>
                        <li class="nav-item"><a class="nav-link" href="author.php">Tác giả</a></li>
                        <li class="nav-item"><a class="nav-link active fw-bold" href="article.php">Bài viết</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-5 mb-5">
        <h3 class="text-center text-uppercase fw-bold">Thêm Mới Bài Viết</h3>
        <form action="" method="post">
            <div class="mb-3">
                <label for="articleTitle" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" id="articleTitle" name="txtTitle" required>
            </div>
            <div class="mb-3">
                <label for="categorySelect" class="form-label">Thể loại</label>
                <select class="form-select" id="categorySelect" name="category_id" required>
                    <option value="">Chọn thể loại</option>
                    <?php
                    foreach ($categories as $category) {
                        echo "<option value=\"{$category['ma_tloai']}\">{$category['ten_tloai']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="authorSelect" class="form-label">Tác giả</label>
                <select class="form-select" id="authorSelect" name="author_id" required>
                    <option value="">Chọn tác giả</option>
                    <?php
                    foreach ($authors as $author) {
                        echo "<option value=\"{$author['ma_tgia']}\">{$author['ten_tgia']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="articleNameSong" class="form-label">Tên bài hát</label>
                <textarea class="form-control" id="articleNameSong" name="txtNameSong" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="articleContent" class="form-label">Tóm tắt</label>
                <textarea class="form-control" id="articleContent" name="txtContent" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Thêm" class="btn btn-success">
                <a href="index.php?controller=article&action=index" class="btn btn-warning">Quay lại</a>
            </div>
        </form>
    </main>
    <footer class="bg-light text-center text-uppercase fw-bold border-top border-secondary border-2" style="height:80px;">
        Khu vườn âm nhạc TLU
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>