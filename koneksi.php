<?php
// Koneksi ke database
$server = "localhost";
$user = "rangga";
$password = "rangga";
$database = "avengers";

// Koneksi
$koneksi = mysqli_connect($server, $user, $password, $database) or die(mysqli_error($koneksi));

// Cek Koneksi
function printDie(...$vars)
{
    foreach ($vars as $var) {
        echo '<pre>';
        print_r($var); // Menampilkan informasi tentang variabel
        echo '</pre>';
    }
    die(); // Menghentikan eksekusi skrip
}

// printDie($koneksi);

?>