<?php
// controllers/HomepageController.php

include("services/HomepageService.php");

class HomepageController {
    public function showHomepage() {
        $homepageService = new HomepageService();
        $homepages = $homepageService->getAllHomepage();
        // Nhiệm vụ 2: Tương tác với View
        
        include 'views/homepage/index.php'; // Hiển thị trang homepage
       
    }
}