<?php
include '../db.php'; // Kết nối CSDL

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Xử lý thêm bài viết
if ($action == 'add' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_bviet = $_POST['ma_bviet'];
    $tieude = $_POST['tieude'];
    $ten_bhat = $_POST['ten_bhat'];
    $ma_tloai = $_POST['ma_tloai'];
    $tomtat = $_POST['tomtat'];
    $ma_tgia = $_POST['ma_tgia'];
    $ngayviet = $_POST['ngayviet'];

    $sql = "INSERT INTO baiviet (ma_bviet,tieude, ten_bhat, ma_tloai, tomtat, ma_tgia, ngayviet) VALUES (? ,?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issiisi",$ma_bviet, $tieude, $ten_bhat, $ma_tloai, $tomtat, $ma_tgia, $ngayviet);
    $stmt->execute();

    echo "<div class='alert alert-success'>Bài viết đã được thêm!</div>";
}


// Xử lý xóa bài viết
if ($action == 'delete' && isset($_GET['ma_bviet'])) {
    $ma_bviet = $_GET['ma_bviet'];

    $sql = "DELETE FROM baiviet WHERE ma_bviet = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_bviet);
    $stmt->execute();

    echo "<div class='alert alert-success'>Bài viết đã được xóa!</div>";
}

// Xử lý cập nhật bài viết
if ($action == 'update' && isset($_GET['ma_bviet']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_bviet = $_GET['ma_bviet'];
    $tieude = $_POST['tieude'];
    $tomtat = $_POST['tomtat'];

    $sql = "UPDATE baiviet SET tieude = ?, tomtat = ? WHERE ma_bviet = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $tieude, $tomtat, $ma_bviet);
    $stmt->execute();

    echo "<div class='alert alert-success'>Bài viết đã được cập nhật!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Bài Viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Di chuyển đến form sửa bài viết khi trang được load với action là "edit"
        window.onload = function() {
            if (window.location.href.indexOf('action=edit') !== -1) {
                document.getElementById('editForm').scrollIntoView({ behavior: 'smooth' });
            }
        };
    </script>
</head>
<body>
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
                        <a class="nav-link " href="category.php">Thể loại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="author.php">Tác giả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="article.php">Bài viết</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-4">
        <!-- Hiển thị danh sách bài viết -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h2>Danh sách Bài Viết</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT ma_bviet, tieude FROM baiviet");
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['tieude']}</td>
                                    <td>
                                        <a href='article.php?action=edit&ma_bviet={$row['ma_bviet']}' class='btn btn-warning btn-sm'>Sửa</a>
                                        <a href='article.php?action=delete&ma_bviet={$row['ma_bviet']}' class='btn btn-danger btn-sm'>Xóa</a>
                                    </td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form thêm bài viết -->
        <div class="container my-4">
        <h2 class="mb-4">Thêm bài viết mới</h2>
        <form action="article.php?action=add" method="POST">
            <div class="mb-3">
                <label for="ma_bviet" class="form-label">Mã bài viết</label>
                <input type="text" class="form-control" id="ma_bviet" name="ma_bviet" required>
            </div>
            <div class="mb-3">
                <label for="tieude" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" id="tieude" name="tieude" required>
            </div>
            <div class="mb-3">
                <label for="ten_bhat" class="form-label">Tên bài hát</label>
                <input type="text" class="form-control" id="ten_bhat" name="ten_bhat" required>
            </div>
            <div class="mb-3">
                <label for="ma_tloai" class="form-label">Thể loại</label>
                <select class="form-control" id="ma_tloai" name="ma_tloai" required>
                    <?php
                    // Lấy danh sách thể loại từ bảng `theloai`
                    include '../db.php';
                    $theloaiResult = $conn->query("SELECT ma_tloai, ten_tloai FROM theloai");
                    while ($theloaiRow = $theloaiResult->fetch_assoc()) {
                        echo "<option value='{$theloaiRow['ma_tloai']}'>{$theloaiRow['ten_tloai']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tomtat" class="form-label">Nội dung tóm tắt</label>
                <textarea class="form-control" id="tomtat" name="tomtat" required></textarea>
            </div>
            <div class="mb-3">
                <label for="ma_tgia" class="form-label">Tác giả</label>
                <select class="form-control" id="ma_tgia" name="ma_tgia" required>
                    <?php
                    // Lấy danh sách tác giả từ bảng `tacgia`
                    $tacgiaResult = $conn->query("SELECT ma_tgia, ten_tgia FROM tacgia");
                    while ($tacgiaRow = $tacgiaResult->fetch_assoc()) {
                        echo "<option value='{$tacgiaRow['ma_tgia']}'>{$tacgiaRow['ten_tgia']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="ngayviet" class="form-label">Ngày viết</label>
                <input type="date" class="form-control" id="ngayviet" name="ngayviet" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm bài viết</button>
        </form>
    </div>

        <!-- Form sửa bài viết -->
        <?php
        if ($action == 'edit' && isset($_GET['ma_bviet'])) {
            $ma_bviet = $_GET['ma_bviet'];
            $result = $conn->query("SELECT tieude, tomtat FROM baiviet WHERE ma_bviet = $ma_bviet");
            $row = $result->fetch_assoc();
        ?>
        <div id="editForm" class="card mb-4">
            <div class="card-header bg-warning text-white">
                <h2>Sửa bài viết</h2>
            </div>
            <div class="card-body">
                <form action="article.php?action=update&ma_bviet=<?php echo $ma_bviet; ?>" method="POST">
                    <div class="mb-3">
                        <label for="tieude" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" id="tieude" name="tieude" value="<?php echo $row['tieude']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tomtat" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="tomtat" name="tomtat" required><?php echo $row['tomtat']; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
                </form>
            </div>
        </div>
        <?php } ?>
    </main>
</body>
</html>

