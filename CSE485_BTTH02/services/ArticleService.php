<?php
include("configs/DBConnection.php");
include("models/Article.php");

class ArticleService {
    public function getAllArticles() {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT * FROM baiviet INNER JOIN theloai ON theloai.ma_tloai = baiviet.ma_tloai";
        $stmt = $conn->query($sql);

        $articles = [];
        while ($row = $stmt->fetch()) {
            $article = new Article($row['ma_bviet'], $row['tieude'], $row['ten_bhat'], $row['tomtat'], $row['ma_tloai']); // Chỉnh sửa để bao gồm tên bài hát
            array_push($articles, $article);
        }

        return $articles;
    }

    public function getAllCategories() {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT * FROM theloai";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAuthors() {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT * FROM tacgia";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAddArticle($title, $nameSong, $category_id, $content) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        if (empty($title) || empty($category_id) || empty($content) || empty($nameSong)) {
            return false;
        }

        $sql = "INSERT INTO baiviet (tieude, ten_bhat, ma_tloai, tomtat) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$title, $nameSong, $category_id, $content]);
    }

    public function getArticleById($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
    
        $sql = "SELECT * FROM baiviet WHERE ma_bviet = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch();
        if ($row) {
            return new Article($row['ma_bviet'], $row['tieude'], $row['ten_bhat'], $row['tomtat'], $row['ma_tloai']);
        }
        return null;
    }

    public function updateArticle($id, $title, $nameSong, $category_id, $content) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "UPDATE baiviet SET tieude = ?, ten_bhat = ?, ma_tloai = ?, tomtat = ? WHERE ma_bviet = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$title, $nameSong, $category_id, $content, $id]);
    }

    public function deleteArticle($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "DELETE FROM baiviet WHERE ma_bviet = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}