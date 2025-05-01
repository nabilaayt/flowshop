<?php

// require_once '../config/database.php';
require_once __DIR__ . '/../config/database.php';

class Category{
    private $conn;
    private $availableCategories;
    private $activeCategory;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        
        $this->availableCategories = [
            'all' => 'All Products',
            'HandBouquet' => 'Hand Bouquet',
            'DecorFlower' => 'Decor Flower',
            'FreshFlower' => 'Fresh Flower',
            'WeddingFlower' => 'Wedding Flower'
        ];
        
        $this->activeCategory = $this->getActiveCategory();
    }

    public function getAvailableCategories(){
        return $this->availableCategories;
    }

    public function getActiveCategory(){
        return isset($_GET['kategori']) ? $_GET['kategori'] : 'all';
    }

    public function getCategoryName($key){
        return $this->availableCategories[$key] ?? 'Unknown Category';
    }

    public function getAllCategories(){
        return array_slice($this->availableCategories, 1);
    }

    public function isActiveCategory($category){
        return $this->getActiveCategory() == $category;
    }
}


?>