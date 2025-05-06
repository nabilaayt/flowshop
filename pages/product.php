<?php

// require_once '../config/database.php';
require_once __DIR__ . '/../config/database.php';

class Product{
    private $conn;
    private $uploadDir = "uploads/";

    public function __construct(){
        $database = new database();
        $this->conn = $database->getConnection();

        // Buat folder upload jika tidak ada
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function getProducts($category = 'all'){
        $products = [];

        if($category === 'all'){
            $query = "SELECT * FROM produk";
            $result = $this->conn->query($query);
        } else {
            $query = "SELECT * FROM produk WHERE kategori = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_Param("s", $category);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $products[] = $row;
            }
        }
        return $products;
    }

    public function getProductById($id){
        $sql = "SELECT * FROM produk WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_Param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 0){
            return null;
        }
        return $result->fetch_assoc();
    }

    public function createProduct($nama, $kategori, $harga, $foto_file = null){
        $foto = "";

        if ($foto_file && $foto_file['error'] == 0) {
            $foto = $this->uploadImage($foto_file);
        }
        
        $sql = "INSERT INTO produk (nama, kategori, harga, foto) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssis", $nama, $kategori, $harga, $foto);
        return $stmt->execute();
    }

    public function updateProduct($id ,$nama, $kategori, $harga, $foto_file = null){
        $product = $this->getProductById($id);

        if(!$product){
            return false;
        }

        $foto = $product['foto'];

        if($foto_file && $foto_file['error'] == 0){
            // Upload gambar baru dan hapus gambar lama
            $newFoto = $this->uploadImage($foto_file);

            if($newFoto){
                if(!empty($foto) && file_exists($foto) && $foto !== './assets/placeholder.jpg'){
                    unlink($foto);
                }
                $foto = $newFoto;
            }
        }

        $sql = "UPDATE produk SET nama = ?, kategori = ?, harga = ?, foto = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssisi", $nama, $kategori, $harga, $foto, $id);
        return $stmt->execute();
    }

    public function deleteProduct($id){
        $sql = "SELECT foto FROM produk WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($row = $result->fetch_assoc()){
            $foto = $row['foto'];

            // Hapus gambar jika ada & tidak kosong
            if (file_exists($foto) && $foto !== '') {
                unlink($foto);
            }
        }

        // Hapus dari database
        $sql = "DELETE FROM produk WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    private function uploadImage($file){
        // validasi jika file adalah gambar
        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            return false;
        }

        // Buat nama file menjadi unik
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $unique_filename = hash('sha256', uniqid(mt_rand(), true)) . '.' . $file_extension;
        $target_file = $this->uploadDir . time() . '_' . $unique_filename;

        // Cek jika file tidak sesuai
        $allowed_types = ['jpg', 'jpeg', 'png'];
        if (!in_array(strtolower($file_extension), $allowed_types)) {
            return false;
        }

        // Upload file
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            return $target_file;
        }
        return false;
    }

    public function importInitialproducts($products){
        $emptyCheck = $this->conn->query("SELECT COUNT(*) as count FROM produk");
        $row = $emptyCheck->fetch_assoc();

        if($row['count'] == 0){
            $stmt = $this->conn->prepare("INSERT INTO produk (foto, nama, kategori, harga) VALUES (?, ?, ?, ?)");

            foreach($products as $product){
                $stmt->bind_param("sssi",
                    $product['foto'],
                    $product['nama'], 
                    $product['kategori'], 
                    $product['harga']
                );
                $stmt->execute();
            }
            return true;
        }
        return false;
    }

    public function searchProduct($keyword) {
        $products = [];
        
        if(empty(trim($keyword))) {
            return $this->getProducts();
        }
        
        $searchKeyword = "%" . $this->conn->real_escape_string($keyword) . "%";
        
        $query = "SELECT * FROM produk WHERE 
                  nama LIKE ? OR
                  kategori LIKE ? OR
                  harga LIKE ?";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $searchKeyword, $searchKeyword, $searchKeyword);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        
        return $products;
    }
}


// Handle AJAX request
if (isset($_GET['keyword'])) {
    $productManager = new Product();
    $searchResults = $productManager->searchProduct($_GET['keyword']);
    
    if(empty($searchResults)): ?>
        <div class="no-product">
            No products found matching your search
        </div>
    <?php else: ?>
        <?php foreach ($searchResults as $product): ?>
            <div class="product">
                <img src="<?php echo htmlspecialchars($product['foto']); ?>" 
                     alt="<?php echo htmlspecialchars($product['nama']); ?>"
                     onerror="this.onerror=null; this.src='./assets/placeholder.jpg';">
                <div class="product-content">
                    <h2><?php echo htmlspecialchars($product['nama']); ?></h2>
                    <p><?php echo htmlspecialchars($product['kategori']); ?></p>
                    <p>Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></p>
                </div>
                <div class="product-actions">
                    <a href="pages/edit.php?id=<?php echo $product['id']; ?>" 
                       class="btn btn-warning">Edit</a>
                    <a href="index.php?hapus=<?php echo $product['id']; ?>" 
                       class="btn-danger" 
                       onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                        Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif;
    exit;
}


?>