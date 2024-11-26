<?php
require_once 'koneksi.php';
global $koneksi;

// Cek jika tombol simpan di klik
if (isset($_POST['bsimpan'])) {
    // Persiapan simpan data
    $sql = "INSERT INTO tmhs (nim,nama,alamat,prodi) 
            VALUES ('$_POST[tnim]','$_POST[tnama]','$_POST[talamat]','$_POST[tprodi]')";
    $simpan = mysqli_query($koneksi, $sql);

    // Jika simpan sukses
    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan');
                document.location = 'index.php';
            </script>";
    } else {
        echo "<script>
                alert('Data gagal Disimpan');
                document.location = 'index.php';
            </script>";
    }
}

// Cek jika tombol ubah di klik
if (isset($_POST['bubah'])) {
    // Persiapan ubah data
    $sql = "UPDATE tmhs SET nim = '$_POST[tnim]', nama = '$_POST[tnama]', alamat = '$_POST[talamat]', prodi = '$_POST[tprodi]' WHERE id_mhs = '$_POST[id_mhs]'";
    $ubah = mysqli_query($koneksi, $sql);

    // Jika ubah sukses
    if ($ubah) {
        echo "<script>
                alert('Data Berhasil Diubah');
                document.location = 'index.php';
            </script>";
    } else {
        echo "<script>
                alert('Data gagal Diubah');
                document.location = 'index.php';
            </script>";
    }
}

// Cek jika tombol hapus di klik
if (isset($_POST['bhapus'])) {
    // Persiapan hapus data
    $sql = "DELETE FROM tmhs WHERE id_mhs = '$_POST[id_mhs]'" ;
    $hapus = mysqli_query($koneksi, $sql);

    // Jika hapus sukses
    if ($hapus) {
        echo "<script>
                alert('Data Berhasil Dihapus');
                document.location = 'index.php';
            </script>";
    } else {
        echo "<script>
                alert('Data gagal Dihapus');
                document.location = 'index.php';
            </script>";
    }
}


?>
