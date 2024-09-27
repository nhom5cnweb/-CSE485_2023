<?php
class HomepageModel {
    private $user;
    private $category;
    private $author;
    
    private $article;

    public function __construct(User $user, Category $category,$author, Article $article) {
        $this->user = $user;
        $this->category = $category;
        $this->author = $author;
        $this->article = $article;
    }

    public function getUser() {
        return $this->user;
    }
    public function getCategory() {
        return $this->category;
    }
    public function getAuthor() {
        return $this->author;
    }
    public function getArticle() {
        return $this->article;
    }
}
?>