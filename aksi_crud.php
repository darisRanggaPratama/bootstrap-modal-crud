<?php
require_once 'koneksi.php';
global $koneksi;

// Cek jika tombol simpan di klik
if (isset($_POST['bsimpan'])) {
    // Persiapan simpan data
    $sql = "INSERT INTO tmhs (nim,nama,alamat,prodi) 
            VALUES ('$_POST[tnim]','$_POST[tnama]','$_POST[talamat]','$_POST[tprodis]')";
    $simpan = mysqli_query($koneksi, $sql);

    // Jika simpan sukses
    if ($simpan) {
        echo "
            <script>
                alert('Data Berhasil Disimpan');
                document.location = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal Disimpan');
                document.location = 'index.php';
            </script>
        ";
    }
}


?>
