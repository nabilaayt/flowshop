<?php

require_once 'product.php';

$initialProducts = [
    [
        'foto' => 'decorFlower1.jpeg',
        'nama' => 'Passion in Bloom',
        'kategori' => 'Decor Flower',
        'harga' => 120000,
    ],
    [
        'foto' => 'decorFlower2.jpeg',
        'nama' => 'Fantasy Bloom',
        'kategori' => 'Decor Flower',
        'harga' => 140000
    ],
    [
        'foto' => 'decorFlower3.jpeg',
        'nama' => 'Sunshine Sun',
        'kategori' => 'Decor Flower',
        'harga' => 110000
    ],
    [
        'foto' => 'decorFlower4.jpeg',
        'nama' => 'Elegance With U',
        'kategori' => 'Decor Flower',
        'harga' => 90000
    ],
    [
        'foto' => 'decorFlower5.jpeg',
        'nama' => 'Red Flame Blossom',
        'kategori' => 'Decor Flower',
        'harga' => 160000
    ],
    [
        'foto' => 'decorFlower6.jpeg',
        'nama' => 'Lavender Mate',
        'kategori' => 'Decor Flower',
        'harga' => 100000
    ]
];

$productManager = new Product();
$result = $productManager->importInitialProducts($initialProducts);

if ($result) {
    echo "Initial data imported successfully!";
} else {
    echo "Data already exists in database!";
}

?>