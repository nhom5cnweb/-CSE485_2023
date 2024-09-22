<?php
include 'db.php';

if (isset($_GET['ma_tgia'])) {
    $ma_tgia = $_GET['ma_tgia'];
    $query = "DELETE FROM tacgia WHERE ma_tgia = $ma_tgia";
    if (mysqli_query($conn, $query)) {
        echo "<div class='alert alert-success'>Xóa tác giả thành công!</div>";
    } else {
        echo "<div class='alert alert-danger'>Có lỗi xảy ra: " . mysqli_error($conn) . "</div>";
    }
}

mysqli_close($conn);

header("Location: list_author.php");
exit();
?>