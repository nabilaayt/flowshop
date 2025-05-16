<?php

session_start();
require_once 'category.php';
require_once 'product.php';
require_once '../components/theme.php';
require_once '../models/userModel.php';

// Inisialisasi objek
$userManager = new User();
$categoryManager = new Category();
$productManager = new Product();
$currentTheme = $themeManager->getCurrentTheme();

// Mengecek akses admin
$userManager->checkAdminAccess();

// Dapatkan ID produk dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id === 0) {
    header('Location: ../index.php');
    exit;
}

// Mendapatkan produk berdasarkan ID
$product = $productManager->getProductById($id);

// Jika produk tidak ditemukan, arahkan ke halaman utama
if (!$product) {
    header('Location: ../index.php');
    exit;
}

// Proses submission
if (isset($_POST['update_produk'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $harga = (int)$_POST['harga'];
    
    // Update produk dengan atau tanpa foto
    $productManager->updateProduct($id, $nama, $kategori, $harga, 
        (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) ? $_FILES['foto'] : null);
    
    // Arahkan ke halaman utama
    header("Location: ../index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="<?php echo $currentTheme; ?>-theme">
    <div class="container">
        <h1>Edit Product</h1>

        <div class="form-container">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama">Name Product</label>
                    <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($product['nama']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="kategori">Category</label>
                    <select id="kategori" name="kategori" required>
                        <?php foreach ($categoryManager->getAllCategories() as $key => $category): ?>
                            <option value="<?php echo $category; ?>" <?php echo ($product['kategori'] === $category) ? 'selected' : ''; ?>>
                                <?php echo $category; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="harga">Price</label>
                    <input type="number" id="harga" name="harga" min="0" value="<?php echo $product['harga']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="foto">Upload Image</label>
                    <img src="<?php echo $product['foto']; ?>" alt="<?php echo $product['nama']; ?>" 
                         onerror="this.onerror=null; this.src='./assets/placeholder.jpg';" 
                         style="max-width: 200px; display: block; margin-bottom: 10px;">
                    <input type="file" id="foto" name="foto" accept="image/*">
                    <small>*Leave blank if you don't want to change the photo</small>
                </div>
                            
                <div class="button-group">
                    <button type="submit" name="update_produk" class="btn btn-primary">Save</button>
                    <a href="../index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <a href="?toggle_theme=1" class="theme-toggle">
        <?php echo $currentTheme === 'dark' ? '☀️' : '🌙'; ?>
    </a>
</body>
</html>