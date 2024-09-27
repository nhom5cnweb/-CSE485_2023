<?php
include("configs/DBConnection.php");
include("models/Homepage.php");
class HomepageService {
    public function getAllHomepage() {
        // B1: Kết nối với cơ sở dữ liệu
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        // B2: Truy vấn
        // Lấy số lượng thể loại
        $categoryCountResult = $conn->query("SELECT COUNT(*) as count FROM theloai");
        $categoryCount = $categoryCountResult->fetch(PDO::FETCH_ASSOC)['count'];

        // Lấy số lượng tác giả
        $authorCountResult = $conn->query("SELECT COUNT(*) as count FROM tacgia");
        $authorCount = $authorCountResult->fetch(PDO::FETCH_ASSOC)['count'];

        // Lấy số lượng bài viết
        $articleCountResult = $conn->query("SELECT COUNT(*) as count FROM baiviet");
        $articleCount = $articleCountResult->fetch(PDO::FETCH_ASSOC)['count'];

        // Lấy danh sách thể loại
        $sql = "SELECT * FROM theloai";
        $result = $conn->query($sql);
        
        // B3: Xử lý kết quả
        $categories = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = $row;
        }

        
}
}