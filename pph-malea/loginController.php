<?php
// Aktifkan session
session_start();

global $connect;


// Koneksi database
include_once 'connect.php';

// Tangkap data yang dikirimkan dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Ambil data user dengan username dan password yang sesuai
$result = mysqli_query($connect, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");

$cek = mysqli_num_rows($result);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($result);
    $_SESSION['username'] = 'username';
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['status'] = 'sudah_login';
    $_SESSION['id_login'] = $data['id'];
    header('location:home.php');
} else {
    header('location:index.php?pesan=GAGAL LOGIN data tidak ditemukan');
}

// https://gilacoding.com/read/tutorial-singkat-login-dengan-php-7-terbaru

