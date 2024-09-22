a. Liệt kê các bài viết về các bài hát thuộc thể loại Nhạc trữ tình
SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, theloai.ten_tloai
FROM baiviet
JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
WHERE theloai.ten_tloai = 'Nhạc trữ tình';


#b. Liệt kê các bài viết của tác giả “Nhacvietplus” 
SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, tacgia.ten_tgia
FROM baiviet
JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
WHERE tacgia.ten_tgia = 'Nhacvietplus';

#c. Liệt kê các thể loại nhạc chưa có bài viết cảm nhận nào. 
SELECT theloai.ma_tloai, theloai.ten_tloai
FROM theloai
LEFT JOIN baiviet ON theloai.ma_tloai = baiviet.ma_tloai
WHERE baiviet.ma_bviet IS NULL;

#d. Liệt kê các bài viết với các thông tin sau: mã bài viết, tên bài viết, tên bài hát, tên tác giả, tên
thể loại, ngày viết. 
SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, tacgia.ten_tgia, theloai.ten_tloai, baiviet.ngayviet
FROM baiviet
JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai;

#e. Tìm thể loại có số bài viết nhiều nhất 
SELECT theloai.ten_tloai, COUNT(baiviet.ma_bviet) AS SoLuongBaiViet
FROM theloai
JOIN baiviet ON theloai.ma_tloai = baiviet.ma_tloai
GROUP BY theloai.ten_tloai
ORDER BY SoLuongBaiViet DESC
LIMIT 1;

#f. Liệt kê 2 tác giả có số bài viết nhiều nhất 
SELECT tacgia.ten_tgia, COUNT(baiviet.ma_bviet) AS SoLuongBaiViet
FROM tacgia
JOIN baiviet ON tacgia.ma_tgia = baiviet.ma_tgia
GROUP BY tacgia.ten_tgia
ORDER BY SoLuongBaiViet DESC
LIMIT 2;

#g. Liệt kê các bài viết về các bài hát có tựa bài hát chứa 1 trong các từ “yêu”, “thương”, “anh”,
“em” 
SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat
FROM baiviet
WHERE baiviet.ten_bhat LIKE '%yêu%'
   OR baiviet.ten_bhat LIKE '%thương%'
   OR baiviet.ten_bhat LIKE '%anh%'
   OR baiviet.ten_bhat LIKE '%em%';

#h. Liệt kê các bài viết về các bài hát có tiêu đề bài viết hoặc tựa bài hát chứa 1 trong các từ
“yêu”, “thương”, “anh”, “em” 
SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat
FROM baiviet
WHERE baiviet.tieude LIKE '%yêu%'
   OR baiviet.tieude LIKE '%thương%'
   OR baiviet.tieude LIKE '%anh%'
   OR baiviet.tieude LIKE '%em%'
   OR baiviet.ten_bhat LIKE '%yêu%'
   OR baiviet.ten_bhat LIKE '%thương%'
   OR baiviet.ten_bhat LIKE '%anh%'
   OR baiviet.ten_bhat LIKE '%em%';

#i. Tạo 1 view có tên vw_Music để hiển thị thông tin về Danh sách các bài viết kèm theo Tên
thể loại và tên tác giả 
CREATE VIEW vw_Music
SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, tacgia.ten_tgia, theloai.ten_tloai, baiviet.ngayviet
FROM baiviet
JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai;

#j. Tạo 1 thủ tục có tên sp_DSBaiViet với tham số truyền vào là Tên thể loại và trả về danh sách
Bài viết của thể loại đó. Nếu thể loại không tồn tại thì hiển thị thông báo lỗi. 
DELIMITER //

CREATE PROCEDURE sp_DSBaiViet(IN tenTheLoai VARCHAR(50))
BEGIN
    IF EXISTS (SELECT * FROM theloai WHERE ten_tloai = tenTheLoai) THEN
        SELECT 
            baiviet.ma_bviet, 
            baiviet.tieude, 
            baiviet.ten_bhat, 
            tacgia.ten_tgia, 
            baiviet.ngayviet 
        FROM 
            baiviet
        JOIN 
            theloai ON baiviet.ma_tloai = theloai.ma_tloai
        JOIN 
            tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
        WHERE 
            theloai.ten_tloai = tenTheLoai;
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Thể loại không tồn tại';
    END IF;
END //

DELIMITER ;


#k. Thêm mới cột SLBaiViet vào trong bảng theloai. 
ALTER TABLE theloai
ADD SLBaiViet INT DEFAULT 0;

#Tạo 1 trigger có tên tg_CapNhatTheLoai để
khi thêm/sửa/xóa bài viết thì số lượng bài viết trong bảng theloai được cập nhật theo. 
#thêm
DELIMITER //

CREATE TRIGGER tg_CapNhatTheLoai_Insert
AFTER INSERT ON baiviet
FOR EACH ROW
BEGIN
    UPDATE theloai
    SET SLBaiViet = (SELECT COUNT(*) FROM baiviet WHERE baiviet.ma_tloai = theloai.ma_tloai);
END //

DELIMITER ;
#sửa
DELIMITER //

CREATE TRIGGER tg_CapNhatTheLoai_Update
AFTER UPDATE ON baiviet
FOR EACH ROW
BEGIN
    -- Cập nhật số lượng bài viết cho thể loại sau khi bài viết được cập nhật
    UPDATE theloai
    SET SLBaiViet = (SELECT COUNT(*) FROM baiviet WHERE baiviet.ma_tloai = theloai.ma_tloai);
END //

DELIMITER ;
#xóa
DELIMITER //

CREATE TRIGGER tg_CapNhatTheLoai_Delete
AFTER DELETE ON baiviet
FOR EACH ROW
BEGIN
    -- Cập nhật số lượng bài viết cho thể loại sau khi bài viết bị xóa
    UPDATE theloai
    SET SLBaiViet = (SELECT COUNT(*) FROM baiviet WHERE baiviet.ma_tloai = theloai.ma_tloai);
END //

DELIMITER ;
#l. Bổ sung thêm bảng Users để lưu thông tin Tài khoản đăng nhập và sử dụng cho chức năng
Đăng nhập/Quản trị trang web.
CREATE TABLE Users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,   -- Khóa chính, tự động tăng
    username VARCHAR(100) NOT NULL UNIQUE,   -- Tên tài khoản, không được trùng lặp
    password VARCHAR(250) NOT NULL,          -- Mật khẩu đã mã hóa, độ dài 255 để chứa chuỗi mã hóa
    `role` varchar(10) NOT NULL DEFAULT '0' COMMENT '0 là user 1 là admin'
);
#tạo user
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('user1', '1', '0'),
('admin', '1', '1');
