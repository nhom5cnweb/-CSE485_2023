<?php
// Kết nối đến cơ sở dữ liệu
include 'db.php';

// Xử lý form khi nhấn nút "Thêm"
if (isset($_POST['submit'])) {
    $ten_tgia = $_POST['ten_tgia'];
    $hinh_tgia = $_FILES['hinh_tgia']['name'];

    // Kiểm tra nếu đã tải lên ảnh
    if ($hinh_tgia != '') {
        $target = "uploads/" . basename($hinh_tgia);
        move_uploaded_file($_FILES['hinh_tgia']['tmp_name'], $target);
    }

    // Chèn thông tin tác giả vào cơ sở dữ liệu
    $query = "INSERT INTO tacgia (ten_tgia, hinh_tgia) VALUES ('$ten_tgia', '$hinh_tgia')";
    if (mysqli_query($conn, $query)) {
        echo "<div class='alert alert-success'>Thêm tác giả thành công!</div>";
    } else {
        echo "<div class='alert alert-danger'>Có lỗi xảy ra: " . mysqli_error($conn) . "</div>";
    }
}

mysqli_close($conn);  // Đóng kết nối cơ sở dữ liệu
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music for Life</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style_login.css">
</head>
<>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="#">Administration</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Trang ngoài</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php">Thể loại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="author.php">Tác giả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="article.php">Bài viết</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5 mb-5">
        <div class="row">
            <div class="col-sm">
                <body>
                    <div class="container mt-5">
                        <h2 class="text-center">THÊM MỚI TÁC GIẢ</h2>

                        <!--Form thêm tác giả-->
                        <form action="add_author.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="ten_tgia" class="form-label">Tên tác giả</label>
                                <input type="text" class="form-control" id="ten_tgia" name="ten_tgia" placeholder="Nhập tên tác giả" required>
                            </div>
                            <!--<div class="mb-3">
                                <label for="hinh_tgia" class="form-label">Hình Ảnh Tác Giả</label>
                                <input type="file" class="form-control" id="hinh_tgia" name="hinh_tgia">
                            </div>-->
                            <!--<button type="submit" name="submit" class="btn btn-success">Thêm</button>
                            <a href="author_list.php" class="btn btn-warning">Quay lại</a>-->
                            <div class="form-group float-end">
                                <input type="submit" value="Thêm" class="btn btn-success">
                                <a href="author.php" class="btn btn-warning">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </body>
            </div>
        </div>
        <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary  border-2" style="height:80px">
            <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </main>
</html>

