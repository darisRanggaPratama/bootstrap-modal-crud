<?php
require_once 'koneksi.php';
global $koneksi;

// Function untuk handle upload CSV
function handleCsvUpload($file) {
    global $koneksi;
    $target_dir = "uploads/";

    // Buat direktori jika belum ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Cek apakah file adalah CSV
    if($fileType != "csv") {
        return "Hanya file CSV yang diperbolehkan.";
    }

    // Upload file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        // Baca file CSV
        if (($handle = fopen($target_file, "r")) !== FALSE) {
            // Skip baris header
            fgetcsv($handle, 1000, ";");

            $success = 0;
            $failed = 0;

            // Baca data baris per baris
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $nim = mysqli_real_escape_string($koneksi, $data[0]);
                $nama = mysqli_real_escape_string($koneksi, $data[1]);
                $alamat = mysqli_real_escape_string($koneksi, $data[2]);
                $prodi = mysqli_real_escape_string($koneksi, $data[3]);

                $sql = "INSERT INTO tmhs (nim, nama, alamat, prodi) 
                        VALUES ('$nim', '$nama', '$alamat', '$prodi')";

                if(mysqli_query($koneksi, $sql)){
                    $success++;
                } else {
                    $failed++;
                }
            }
            fclose($handle);
            unlink($target_file); // Hapus file setelah diproses

            return "Berhasil mengupload " . $success . " data, gagal " . $failed . " data.";
        }
    } else {
        return "Maaf, terjadi error saat mengupload file.";
    }
}

// Function untuk download CSV
function generateCsv() {
    global $koneksi;

    // Set header untuk download file
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data_mahasiswa.csv');

    // Buat file pointer untuk output
    $output = fopen('php://output', 'w');

    // Tulis header CSV
    fputcsv($output, array('NIM', 'Nama', 'Alamat', 'Prodi'), ';');

    // Ambil data dari database
    $sql = "SELECT nim, nama, alamat, prodi FROM tmhs ORDER BY id_mhs DESC";
    $result = mysqli_query($koneksi, $sql);

    // Tulis data ke CSV
    while($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row, ';');
    }

    fclose($output);
    exit();
}
?>
