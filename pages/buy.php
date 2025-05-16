<?php

session_start();
require_once '../models/userModel.php';

// Pastikan user sudah login
if(empty($_SESSION["id"])){
    header("Location: ../components/login.php");
    exit();
}

class BuyHandler{
    private $userId;
    private $productId;

    public function __construct($userId, $productId) {
        $this->userId = $userId;
        $this->productId = $productId;
    }

    public function process(){
        if (!$this->isValidProductId()) {
            $this->setNotification("ID produk tidak valid!", "error");
            $this->redirect("../index.php#product");
        }

        $this->setNotification("Product purchased successfully! Thank you for your purchase.", "success");
        $this->redirect("../index.php#product");
    }

    private function isValidProductId() {
        return is_numeric($this->productId) && $this->productId > 0;
    }

    private function setNotification($message, $type) {
        $_SESSION['notification'] = [
            'message' => $message,
            'type' => $type
        ];
    }

    private function redirect($url) {
        header("Location: $url");
        exit();
    }
}

// Ambil ID produk dari parameter GET
$productId = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Proses pembelian
$handler = new BuyHandler($_SESSION["id"], $productId);
$handler->process();

?>