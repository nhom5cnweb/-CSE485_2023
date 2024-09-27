<?php

// B1: Bắt giá trị controller và action
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home'; // Mặc định là 'home'
$action = isset($_GET['action']) ? $_GET['action'] : 'index'; // Mặc định là 'index'

// B2: Chuẩn hóa tên trước khi gọi
$controller = ucfirst($controller) . 'Controller';
$controllerPath = 'controllers/' . $controller . '.php';


// B3. Để gọi nó Controller
if (!file_exists($controllerPath)) {
    die('Lỗi! Controller này không tồn tại');
}
require_once($controllerPath);

// B4. Tạo đối tượng và gọi hàm của Controller
$myObj = new $controller(); // Khởi tạo controller với kết nối CSDL

// Gọi action tương ứng
if (method_exists($myObj, $action)) {
    $myObj->$action();
} else {
    echo "Action không tồn tại!";
}
?>