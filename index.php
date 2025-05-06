<?php

session_start();
require_once 'pages/category.php';
require_once 'pages/product.php';
require_once 'components/theme.php';

$db = new Database();
$conn = $db->getConnection();

$currentTheme = getCurrentTheme();

// Periksa apakah user sudah login/belum
if(empty($_SESSION["id"])){
    header("Location: components/login.php");
    exit();
}

// Ambil data user jika sudah login
$id = $_SESSION["id"];
$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();


// Inisialisasi objek
$categoryManager = new Category();
$productManager = new Product();

$availableCategories = $categoryManager->getAvailableCategories();
$activeCategory = $categoryManager->getActiveCategory();

// Memilih produk berdasarkan kategori
if ($activeCategory === 'all') {
    $filteredProducts = $productManager->getProducts();
} else {
    $categoryName = $categoryManager->getCategoryName($activeCategory);
    $filteredProducts = $productManager->getProducts($categoryName);
}

// Penambahan Produk Baru
if (isset($_POST['tambah_produk'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $harga = (int)$_POST['harga'];
    
    $productManager->createProduct($nama, $kategori, $harga, $_FILES['foto'] ?? null);
    
    // Menghindari pengiriman ulang
    header('Location: ' . $_SERVER['PHP_SELF'] . (isset($_GET['kategori']) ? '?kategori=' . $_GET['kategori'] : ''));
    exit;
}

// Proses penghapusan produk
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    
    $productManager->deleteProduct($id);
    
    // Menghindari beberapa penghapusan
    header('Location: ' . $_SERVER['PHP_SELF'] . (isset($_GET['kategori']) ? '?kategori=' . $_GET['kategori'] : ''));
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FLOWSHOP</title>
    <script src="js/jquery-3.7.1.js"></script>
    <script src="js/script.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="./assets/style.css">
    
</head>
<body class="<?php echo $currentTheme; ?>-theme">
    <header>
        <div class="headerLeft">
            <i class="toggleMenu bx bx-menu"></i>
            <a href="" class="title">FLOWSHOP</a>
        </div>
        <div class="search">
            <div class="search-container">
                <i class='bx bx-search'></i>
                <input type="text" name="keyword" placeholder="Find your favorite flower products here..." 
                    autocomplete="off" id="keyword">
                <button type="button" id="btn-cari">Cari</button>
            </div>
        </div>
        <div class="nav">
            <ul class="menu">
                <li class="lnk"><a href="#main">Home</a></li>
                <li class="lnk"><a href="#add">Add Product</a></li>
                <li class="lnk"><a href="#product">Product</a></li>
                <li class= "logout"><a href="components/logout.php">Log Out</a></li>
                <li>
                    <a href="?toggle_theme=1" class="theme-toggle">
                        <?php echo $currentTheme === 'dark' ? '☀️' : '🌙'; ?>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <main id="main" class="hero-section">
        <div class="hero-content">
            <h1>FLOWSHOP</h1>
            <p>Welcome to FLOWSHOP, where every bouquet is crafted with love and beauty. Find the perfect arrangement for your special moments and surprise your loved ones!</p>
            <a href="#product" class="btn-main">See More</a>
        </div>
    </main>

    <!-- Form tambah produk -->
    <div class="add-product" id= "add">
        <h1>Product Management</h1>
        <p>Manage and showcase your beautiful floral arrangements effortlessly. Add new products, set categories, and update pricing to keep your shop fresh and inviting!</p>
        <div class="form-container">
            <h2>Add New Product</h2>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama">Name Product</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama produk" required>
                </div>
                
                <div class="form-group">
                    <label for="kategori">Category</label>
                    <select id="kategori" name="kategori" required>
                        <?php foreach ($categoryManager->getAllCategories() as $key => $category): ?>
                            <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="harga">Price</label>
                    <input type="number" id="harga" name="harga" min="0" placeholder="Masukkan harga produk" required>
                </div>
                
                <div class="form-group">
                    <label for="foto">Upload Image</label>
                    <input type="file" id="foto" name="foto" accept="image/*" required>
                </div>
                
                <button type="submit" name="tambah_produk" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </div>

    <div class="container" id="container">
    <h1>Products Set</h1>
    <div class="list-menu">
        <ul>
            <?php foreach ($availableCategories as $key => $category): ?>
                <li class="<?php echo $categoryManager->isActiveCategory($key) ? 'active' : ''; ?>">
                    <a href="?kategori=<?php echo $key; ?>">
                        <?php echo $category; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

        <div class="product-container" id="product">
            <?php if(empty($filteredProducts)): ?>
                <div class="no-product">
                    There are no products in this category
                </div>
            <?php else: ?>
                <?php foreach ($filteredProducts as $product): ?>
                    <div class="product">
                        <img 
                            src="<?php echo $product['foto']; ?>" 
                            alt="<?php echo $product['nama']; ?>" 
                            onerror="this.onerror=null; this.src='./assets/placeholder.jpg';">
                        <div class="product-content">
                            <h2><?php echo $product['nama']; ?></h2>
                            <p><?php echo $product['kategori']; ?></p>
                            <p>Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></p>
                        </div>
                        <div class="product-actions">
                            <a href="pages/edit.php?id=<?php echo $product['id']; ?>" 
                               class="btn btn-warning">Edit</a>
                            <a href="?hapus=<?php echo $product['id']; ?><?php echo isset($_GET['kategori']) ? '&kategori=' . $_GET['kategori'] : ''; ?>" 
                               class="btn-danger" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                Delete
                            </a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>